<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

namespace Net\Bazzline\Component\Fork;

/**
 * Class Manager
 * @package Net\Bazzline\Component\Fork
 */
class Manager implements ExecutableInterface
{
    /**
     * @var int
     */
    private $maximumNumberOfThreads;

    /**
     * @var int
     */
    private $maximumSecondsOfRunTime;

    /**
     * @var MemoryLimitManager
     */
    private $memoryLimitManager;

    /**
     * @var int
     */
    private $minimumDistanceInSecondsBeforeReachingTimeLimit;

    /**
     * @var int
     */
    private $numberOfMicrosecondsToCheckThreadStatus;

    /**
     * @var int
     */
    private $processId;

    /**
     * @var int
     */
    private $startTime;

    /**
     * @var TaskManager
     */
    private $taskManager;

    /**
     * @var TimeLimitManager
     */
    private $timeLimitManager;

    /**
     * @var array
     */
    private $threads;

    /**
     * @throws RuntimeException
     */
    public function __construct()
    {
        //@todo add all needed
        $mandatoryPHPFunctions = array(
            'getmypid',
            'memory_get_usage',
            'pcntl_fork',
            'posix_getpid',
            'spl_object_hash'
        );

        foreach ($mandatoryPHPFunctions as $mandatoryPHPFunction) {
            if (!function_exists($mandatoryPHPFunction)) {
                throw new RuntimeException(
                    'mandatory php function "' . $mandatoryPHPFunction . '" is not available'
                );
            }
        }

        declare(ticks = 10);

        //@todo they have to be injected while object creation
        //@todo create a factory for manager creation
        $this->memoryLimitManager = new MemoryLimitManager();
        $this->taskManager = new TaskManager();
        $this->timeLimitManager = new TimeLimitManager();

        //set default values for optional properties
        $this->memoryLimitManager->setMaximumInMegaBytes(128);
        $this->setMaximumNumberOfThreads(16);
        $this->setMaximumSecondsOfRunTime(3600);  //1 * 60 * 60 = 1 hour
        $this->setNumberOfMicrosecondsToCheckThreadStatus(100000);   //1000000 microseconds = 1 second

        //set values for mandatory properties
        //@todo calculate minimumDistance[...]Limit in setter methods
        $this->memoryLimitManager->setBufferInMegaBytes(8);
        $this->minimumDistanceInSecondsBeforeReachingTimeLimit = 2;
        $this->processId = posix_getpid();
        $this->threads = array();
    }

    /**
     * @param AbstractTask $task
     * @return $this
     */
    public function addTask(AbstractTask $task)
    {
        $task->setParentProcessId($this->processId);
        $this->taskManager->addTask($task);

        return $this;
    }

    /**
     * @return MemoryLimitManager
     */
    public function getMemoryLimitManager()
    {
        return $this->memoryLimitManager;
    }

    /**
     * @return TaskManager
     */
    public function getTaskManager()
    {
        return $this->taskManager;
    }

    /**
     * @return TimeLimitManager
     */
    public function getTimeLimitManager()
    {
        return $this->timeLimitManager;
    }

    /**
     * @param int $maximumNumberOfThreads
     */
    public function setMaximumNumberOfThreads($maximumNumberOfThreads)
    {
        $this->maximumNumberOfThreads = (int) $maximumNumberOfThreads;
    }

    /**
     * @param int $maximumSecondsOfRunTime
     */
    public function setMaximumSecondsOfRunTime($maximumSecondsOfRunTime)
    {
        $this->maximumSecondsOfRunTime = (int) $maximumSecondsOfRunTime;
    }

    /**
     * @param int $numberOfMicrosecondsToCheckThreadStatus
     */
    public function setNumberOfMicrosecondsToCheckThreadStatus($numberOfMicrosecondsToCheckThreadStatus)
    {
        $this->numberOfMicrosecondsToCheckThreadStatus = (int) $numberOfMicrosecondsToCheckThreadStatus;
    }

    /**
     * @throws RuntimeException
     */
    public function execute()
    {
        $this->startTime = time();

        //dispatch event pre execute
        //dispatch event pre executing open tasks
        while ($this->taskManager->areThereOpenTasksLeft()) {
            if ($this->isTimeLimitReached()) {
                $this->stopAllThreads();
            } else if ($this->memoryLimitManager->isLimitReached()) {
                $this->stopNewestThread();
                $this->sleep();
            } else {
                if ($this->isMaximumNumberOfThreadsReached()) {
                    $this->updateNumberOfRunningThreads();
                    $this->sleep();
                } else {
                    $task = $this->taskManager->getOpenTask();
                    //dispatch event pre start thread
                    $this->startThread($task);
                    //dispatch event post start thread
                }
            }
        }
        //dispatch event post executing open tasks

        //dispatch event pre waiting of still running threads
        while ($this->notAllThreadsAreFinished()) {
            if ($this->isTimeLimitReached()) {
                $this->stopAllThreads();
            } else if ($this->memoryLimitManager->isLimitReached()) {
                $this->stopNewestThread();
                $this->sleep();
            } else {
                $this->updateNumberOfRunningThreads();
                $this->sleep();
            }
        }
        //dispatch event post waiting of still running threads

        //dispatch event post execute
    }

    /**
     * @return bool
     */
    private function notAllThreadsAreFinished()
    {
        return ($this->countNumberOfThreads() !== 0);
    }

    private function updateNumberOfRunningThreads()
    {
        foreach ($this->threads as $processId => $data) {
            if ($this->hasThreadFinished($processId)) {
                //dispatch event thread has finished with data
                $this->taskManager->markRunningTaskAsFinished($data['task']);
                unset($this->threads[$processId]);
            }
        }
    }

    /**
     * @param AbstractTask $task
     * @throws RuntimeException
     */
    private function startThread(AbstractTask $task)
    {
        $time = time();
        $processId = pcntl_fork();

        if ($processId < 0) {
            throw new RuntimeException(
                'can not fork process'
            );
        } else if ($processId === 0) {
            //child
            $task->execute();
            exit(0);
        } else {
            //parent
            //$processId > 0
            $this->threads[$processId] = array(
                'startTime' => $time,
                'task' => $task
            );
            $this->taskManager->markTaskAsRunning($task);
        }
    }

    /**
     * @param $processId
     * @throws RuntimeException
     */
    private function stopThread($processId)
    {
        //dispatch event stop thread -> data('process_id' => $processId)
        if ($processId > 0) {
            if (isset($this->threads[$processId])) {
                $isStopped = posix_kill($processId, SIGTERM);
                if ($isStopped) {
                    $task = $this->threads[$processId]['task'];
                    unset($this->threads[$processId]);
                    $this->taskManager->markRunningTaskAsAborted($task);
                } else {
                    throw new RuntimeException(
                        'thread with process id "' . $processId . '" could not be stopped'
                    );
                }
            }
        }
    }

    /**
     * @throws RuntimeException
     */
    private function stopNewestThread()
    {
        $newestProcessId = null;
        $newestStartTime = 0;
        $task = null;

        foreach ($this->threads as $processId => $data) {
            if ($data['startTime'] > $newestStartTime) {
                $newestProcessId = $processId;
            }
        }

        if (!is_null($newestProcessId)) {
            //dispatch event newest thread
            $this->stopThread($newestProcessId);
        }
    }

    /**
     * @throws RuntimeException
     */
    private function stopAllThreads()
    {
        //dispatch event stop all threads
        foreach ($this->threads as $processId => $data) {
            $this->stopThread($processId);
        }
    }

    /**
     * @param int $processId
     * @return int
     * @throws RuntimeException
     */
    private function hasThreadFinished($processId)
    {
        if ($processId > 0) {
            $statusCode = 0;
            $result = pcntl_waitpid($processId, $statusCode, WUNTRACED OR WNOHANG);

            if ($statusCode > 0) {
                throw new RuntimeException(
                    'thread with process id "' . $processId .
                    '" returned statusCode code "' . $statusCode . '"'
                );
            }

            $threadHasFinished = ($result === $processId);
        } else {
            $threadHasFinished = true;
        }

        return $threadHasFinished;
    }

    /**
     * @return int
     */
    private function countNumberOfThreads()
    {
        return count($this->threads);
    }

    /**
     * @return bool
     */
    private function isMaximumNumberOfThreadsReached()
    {
        return ($this->countNumberOfThreads() >= $this->maximumNumberOfThreads);
    }

    private function sleep()
    {
        usleep($this->numberOfMicrosecondsToCheckThreadStatus);
    }

    /**
     * @return bool
     */
    private function isTimeLimitReached()
    {
        //@todo merge startTime and maximumSecondsOfRunTime to property since
        //  it is wasted to recalculate this static value in execution mode
        $isReached = (($this->startTime + $this->maximumSecondsOfRunTime) <
            (time() + $this->minimumDistanceInSecondsBeforeReachingTimeLimit));

        return $isReached;
    }
}
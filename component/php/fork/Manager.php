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
     * @var array
     */
    private $abortedTasks;

    /**
     * @var bool
     */
    private $areThereOpenTasksLeft;

    /**
     * @var array
     */
    private $finishedTasks;

    /**
     * @var int
     */
    private $initialMemoryUsageInBytes;

    /**
     * @var int
     */
    private $maximumBytesOfMemoryUsage;

    /**
     * @var int
     */
    private $maximumNumberOfThreads;

    /**
     * @var int
     */
    private $maximumSecondsOfRunTime;

    /**
     * @var int
     */
    private $minimumDistanceInBytesBeforeReachingMemoryLimit;

    /**
     * @var int
     */
    private $minimumDistanceInSecondsBeforeReachingTimeLimit;

    /**
     * @var int
     */
    private $numberOfMicrosecondsToCheckThreadStatus;

    /**
     * @var array
     */
    private $openTasks;

    /**
     * @var int
     */
    private $processId;

    /**
     * @var array
     */
    private $runningTasks;

    /**
     * @var int
     */
    private $startTime;

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
            'pcntl_fork',
            'posix_getpid'
        );

        foreach ($mandatoryPHPFunctions as $mandatoryPHPFunction) {
            if (!function_exists($mandatoryPHPFunction)) {
                throw new RuntimeException(
                    'mandatory php function "' . $mandatoryPHPFunction . '" is not available'
                );
            }
        }

        declare(ticks = 10);

        //set default values for optional properties
        $this->setMaximumBytesOfMemoryUsage(1073741824);    //1 * 8 * 1024 * 1024 = 128 MB
        $this->setMaximumNumberOfThreads(16);
        $this->setMaximumSecondsOfRunTime(3600);  //1 * 60 * 60 = 1 hour
        $this->setNumberOfMicrosecondsToCheckThreadStatus(100000);   //1000000 microseconds = 1 second

        //set values for mandatory properties
        $this->abortedTasks = array();
        $this->areThereOpenTasksLeft = false;
        $this->finishedTasks = array();
        //@todo calculate minimumDistance[...]Limit in setter methods
        $this->minimumDistanceInBytesBeforeReachingMemoryLimit = 65536; //1 * 6 * 1024 * 8 = 8 MB
        $this->minimumDistanceInSecondsBeforeReachingTimeLimit = 2;
        $this->openTasks = array();
        $this->processId = posix_getpid();
        $this->runningTasks = array();
        $this->threads = array();
    }

    /**
     * @param AbstractTask $task
     * @return $this
     */
    public function addTask(AbstractTask $task)
    {
        $task->setParentProcessId($this->processId);
        $this->openTasks[] = $task;
        $this->areThereOpenTasksLeft = true;

        return $this;
    }

    /**
     * @param int $maximumBytesOfMemoryUsage
     */
    public function setMaximumBytesOfMemoryUsage($maximumBytesOfMemoryUsage)
    {
        $this->maximumBytesOfMemoryUsage = (int) $maximumBytesOfMemoryUsage;
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
        $this->initialMemoryUsageInBytes = memory_get_usage(true);
        $this->startTime = time();

        //dispatch event pre execute
        while ($this->areThereOpenTasksLeft) {
            if ($this->isTimeLimitReached()) {
                $this->stopAllThreads();
            } else if ($this->isMemoryLimitReached()) {
                $this->stopNewestThread();
            } else {
                if ($this->isMaximumNumberOfThreadsReached()) {
                    $this->updateNumberOfRunningThreads();
                    $this->sleep();
                } else {
                    $task = $this->getOpenTask();
                    //dispatch event pre start thread
                    $this->startThread($task);
                    //dispatch event post start thread
                }
            }
        }

        while ($this->notAllThreadsAreFinished()) {
            $this->updateNumberOfRunningThreads();
            $this->sleep();
        }

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
                $this->moveTaskFromRunningToFinished($processId);
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
            );
            $this->runningTasks[$processId] = $task;
        }
    }

    /**
     * @param $processId
     */
    private function stopThread($processId)
    {
        //dispatch event stop thread -> data('process_id' => $processId)
        if ($processId > 0) {
            if (isset($this->threads[$processId])) {
                posix_kill($processId, SIGTERM);
            }
        }
    }

    private function stopNewestThread()
    {
        $newestProcessId = null;
        $newestStartTime = 0;

        foreach ($this->threads as $processId => $startTime) {
            if ($startTime > $newestStartTime) {
                $newestProcessId = $processId;
            }
        }

        if (!is_null($newestProcessId)) {
            //dispatch event newest thread
            $this->stopThread($newestProcessId);
            $this->moveTaskFromRunningToAborted($newestProcessId);
        }
    }

    private function stopAllThreads()
    {
        //dispatch event stop all threads
        foreach ($this->threads as $processId => $startTime) {
            $this->stopThread($processId);
            $this->moveTaskFromRunningToAborted($processId);
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
     * @return mixed
     */
    private function getOpenTask()
    {
        $task = array_shift($this->openTasks);

        if (empty($this->openTasks)) {
            $this->areThereOpenTasksLeft = false;
        }

        return $task;
    }

    /**
     * @param $processId
     */
    private function moveTaskFromRunningToAborted($processId)
    {
        $this->abortedTasks[$processId] = $this->runningTasks[$processId];
        unset($this->runningTasks[$processId]);
    }

    /**
     * @param $processId
     */
    private function moveTaskFromRunningToFinished($processId)
    {
        $this->finishedTasks[$processId] = $this->runningTasks[$processId];
        unset($this->runningTasks[$processId]);
    }

    /**
     * @return bool
     */
    private function isTimeLimitReached()
    {
        return false;
        $isReached = (($this->startTime + $this->maximumSecondsOfRunTime) >=
            (time() + $this->minimumDistanceInSecondsBeforeReachingTimeLimit));

        return $isReached;
    }

    /**
     * @return bool
     */
    private function isMemoryLimitReached()
    {
        return false;
        $isReached = (($this->initialMemoryUsageInBytes + $this->maximumBytesOfMemoryUsage) >=
            (memory_get_usage(true) + $this->minimumDistanceInBytesBeforeReachingMemoryLimit));

        return $isReached;
    }
}
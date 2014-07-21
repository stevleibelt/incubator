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
     * @var bool
     */
    private $areThereOpenTasksLeft;

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
    private $numberOfMicrosecondsToCheckThreadStatus;

    /**
     * @var int
     */
    private $processId;

    /**
     * @var array
     */
    private $tasks;

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
        $this->maximumBytesOfMemoryUsage = 1073741824;  //1 * 8 * 1024 * 1024 = 128 MB
        $this->maximumNumberOfThreads = 16;
        $this->maximumSecondsOfRunTime = 3600;  //1 * 60 * 60 = 1 hour
        $this->numberOfMicrosecondsToCheckThreadStatus = 100;

        //set values for mandatory properties
        $this->areThereOpenTasksLeft = false;
        $this->processId = posix_getpid();
        $this->tasks = array();
        $this->threads = array();
    }

    /**
     * @param AbstractTask $task
     * @return $this
     */
    public function addTask(AbstractTask $task)
    {
        $task->setParentProcessId($this->processId);
        $this->tasks[] = $task;
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
        //dispatch event pre execute
        while ($this->areThereOpenTasksLeft) {
            //----
            if ($this->isMaximumNumberOfThreadsReached()) {
                $this->updateNumberOfRunningThreads();
                $this->sleep();
            } else {
                $task = $this->getOpenTask();
                //dispatch event pre start thread
                // TODO: Implement execute() method.
                $this->startThread($task);
                //dispatch event post start thread
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
        $memoryUsage = memory_get_usage(true);
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
                //really needed?
                'memoryUsage' => $memoryUsage,
                'time' => $time,
            );
        }
    }

    private function stopThread($processId)
    {
        if ($processId > 0) {
            if (isset($this->threads[$processId])) {
                posix_kill($processId, SIGTERM);
            }
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
        $task = array_shift($this->tasks);

        if (empty($this->tasks)) {
            $this->areThereOpenTasksLeft = false;
        }

        return $task;
    }
}
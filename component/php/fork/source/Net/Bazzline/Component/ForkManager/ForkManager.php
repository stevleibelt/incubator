<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

namespace Net\Bazzline\Component\ForkManager;

use Net\Bazzline\Component\MemoryLimitManager\MemoryLimitManager;
use Net\Bazzline\Component\MemoryLimitManager\MemoryLimitManagerDependentInterface;
use Net\Bazzline\Component\TimeLimitManager\TimeLimitManager;
use Net\Bazzline\Component\TimeLimitManager\TimeLimitManagerDependentInterface;

/**
 * Class ForkManager
 * @package Net\Bazzline\Component\Fork
 */
class ForkManager implements ExecutableInterface, MemoryLimitManagerDependentInterface, TimeLimitManagerDependentInterface
{
    /**
     * @var int
     */
    private $maximumNumberOfThreads;

    /**
     * @var MemoryLimitManager
     */
    private $memoryLimitManager;

    /**
     * @var int
     */
    private $numberOfMicrosecondsToCheckThreadStatus;

    /**
     * @var int
     */
    private $processId;

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
     * @param bool $validateEnvironment
     * @throws RuntimeException
     */
    public function __construct($validateEnvironment = true)
    {
        if ($validateEnvironment) {
            //@todo add all needed
            $mandatoryPHPFunctions = array(
                'getmypid',
                'memory_get_usage',
                'pcntl_fork',
                'pcntl_signal',
                'pcntl_signal_dispatch',
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
        }

        declare(ticks = 10);

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
        $this->taskManager->addOpenTask($task);

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
     * @param MemoryLimitManager $manager
     */
    public function injectMemoryLimitManager(MemoryLimitManager $manager)
    {
        $this->memoryLimitManager = $manager;
    }

    /**
     * @param TimeLimitManager $manager
     */
    public function injectTimeLimitManager(TimeLimitManager $manager)
    {
        $this->timeLimitManager = $manager;
    }

    /**
     * @param TaskManager $manager
     */
    public function injectTaskManager(TaskManager $manager)
    {
        $this->taskManager = $manager;
    }

    /**
     * @param int $maximumNumberOfThreads
     */
    public function setMaximumNumberOfThreads($maximumNumberOfThreads)
    {
        $this->maximumNumberOfThreads = (int) $maximumNumberOfThreads;
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
        $this->setUpSignalHandling('signalHandler');
        //dispatch event pre execute
        //dispatch event pre executing open tasks
        while ($this->taskManager->areThereOpenTasksLeft()) {
            if ($this->timeLimitManager->isLimitReached()) {
                $this->stopAllThreads();
            } else if ($this->isMaximumMemoryLimitOfWholeThreadsReached()) {
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
            if ($this->timeLimitManager->isLimitReached()) {
                $this->stopAllThreads();
            } else if ($this->isMaximumMemoryLimitOfWholeThreadsReached()) {
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
            $this->taskManager->markOpenTaskAsRunning($task);
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
     * @todo think about the idea to put this in a "HandleMaximumMemoryLimitReachedStrategy"
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

    /**
     * @return bool
     */
    private function isMaximumMemoryLimitOfWholeThreadsReached()
    {
        $processIds = array_keys($this->threads);

        $isReached = $this->memoryLimitManager->isLimitReached($processIds);

        return $isReached;
    }

    private function sleep()
    {
        $this->dispatchSignal();
        usleep($this->numberOfMicrosecondsToCheckThreadStatus);
    }

    //begin of posix signal handling
    /**
     * @param int $signal
     */
    private function signalHandler($signal)
    {
        //dispatch event caught signal
        $this->stopAllThreads();
    }

    private function dispatchSignal()
    {
        pcntl_signal_dispatch();
    }

    /**
     * @param $nameOfSignalHandlerMethod
     * @throws InvalidArgumentException
     */
    private function setUpSignalHandling($nameOfSignalHandlerMethod)
    {
        if (!is_callable($nameOfSignalHandlerMethod)) {
            throw new InvalidArgumentException(
                'provided method name "' . $nameOfSignalHandlerMethod . '" is not available'
            );
        }

        pcntl_signal(SIGHUP,    array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGINT,    array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGUSR1,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGUSR2,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGQUIT,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGILL,    array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGABRT,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGFPE,    array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGSEGV,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGPIPE,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGALRM,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGTERM,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGCHLD,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGCONT,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGTSTP,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGTTIN,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGTTOU,   array($this, $nameOfSignalHandlerMethod));
    }
    //end of posix signal handling
}
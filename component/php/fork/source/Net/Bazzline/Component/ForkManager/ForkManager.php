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
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class ForkManager
 * @package Net\Bazzline\Component\Fork
 */
class ForkManager implements ExecutableInterface, MemoryLimitManagerDependentInterface, TimeLimitManagerDependentInterface
{
    const EVENT_ADDING_SIGNAL_HANDLER                               = 0;
    const EVENT_AFTER_EXECUTE                                       = 1;
    const EVENT_AFTER_EXECUTING_OPEN_TASKS                          = 2;
    const EVENT_AFTER_WAITING_UNTIL_ALL_RUNNING_TASKS_ARE_FINISHED  = 3;
    const EVENT_AFTER_STARTING_NEW_THREAD                           = 4;
    const EVENT_BEFORE_EXECUTE                                      = 5;
    const EVENT_BEFORE_EXECUTING_OPEN_TASKS                         = 6;
    const EVENT_BEFORE_STARTING_NEW_THREAD                          = 7;
    const EVENT_BEFORE_WAITING_UNTIL_ALL_RUNNING_TASKS_ARE_FINISHED = 8;
    const EVENT_MEMORY_LIMIT_REACHED                                = 9;
    const EVENT_THREAD_HAS_FINISHED_WORK                            = 10;
    const EVENT_THREAD_HAS_STARTED_WORK                             = 11;
    const EVENT_THREAD_WAS_STOPPED                                  = 12;
    const EVENT_TIME_LIMIT_REACHED                                  = 13;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

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
     * @return EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
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
     * @param EventDispatcher $dispatcher
     */
    public function injectEventDispatcher(EventDispatcher $dispatcher)
    {
        $this->eventDispatcher = $dispatcher;
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
        $this->assertMandatoryPropertiesAreSet();
        $this->eventDispatcher->dispatch(self::EVENT_BEFORE_EXECUTE);
        $this->eventDispatcher->dispatch(self::EVENT_ADDING_SIGNAL_HANDLER);
        $this->setUpSignalHandling('signalHandler');
        $this->eventDispatcher->dispatch(self::EVENT_BEFORE_EXECUTING_OPEN_TASKS);

        while ($this->taskManager->areThereOpenTasksLeft()) {
            if ($this->timeLimitManager->isLimitReached()) {
                $this->eventDispatcher->dispatch(self::EVENT_TIME_LIMIT_REACHED);
                $this->stopAllThreads();
            } else if ($this->isMaximumMemoryLimitOfWholeThreadsReached()) {
                $this->eventDispatcher->dispatch(self::EVENT_MEMORY_LIMIT_REACHED);
                $this->stopNewestThread();
                $this->sleep();
            } else {
                if ($this->isMaximumNumberOfThreadsReached()) {
                    $this->updateNumberOfRunningThreads();
                    $this->sleep();
                } else {
                    $task = $this->taskManager->getOpenTask();
                    $this->eventDispatcher->dispatch(self::EVENT_BEFORE_STARTING_NEW_THREAD);
                    $this->startThread($task);
                    $this->eventDispatcher->dispatch(self::EVENT_AFTER_STARTING_NEW_THREAD);
                }
            }
        }

        $this->eventDispatcher->dispatch(self::EVENT_AFTER_EXECUTING_OPEN_TASKS);
        $this->eventDispatcher->dispatch(self::EVENT_BEFORE_WAITING_UNTIL_ALL_RUNNING_TASKS_ARE_FINISHED);

        while ($this->notAllThreadsAreFinished()) {
            if ($this->timeLimitManager->isLimitReached()) {
                $this->eventDispatcher->dispatch(self::EVENT_TIME_LIMIT_REACHED);
                $this->stopAllThreads();
            } else if ($this->isMaximumMemoryLimitOfWholeThreadsReached()) {
                $this->eventDispatcher->dispatch(self::EVENT_MEMORY_LIMIT_REACHED);
                $this->stopNewestThread();
                $this->sleep();
            } else {
                $this->updateNumberOfRunningThreads();
                $this->sleep();
            }
        }

        $this->eventDispatcher->dispatch(self::EVENT_AFTER_WAITING_UNTIL_ALL_RUNNING_TASKS_ARE_FINISHED);
        $this->eventDispatcher->dispatch(self::EVENT_AFTER_EXECUTE);
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
                $this->eventDispatcher->dispatch(self::EVENT_THREAD_HAS_FINISHED_WORK);
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
            $this->eventDispatcher->dispatch(self::EVENT_THREAD_HAS_STARTED_WORK);
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
        if ($processId > 0) {
            if (isset($this->threads[$processId])) {
                $isStopped = posix_kill($processId, SIGTERM);
                if ($isStopped) {
                    $this->eventDispatcher->dispatch(self::EVENT_THREAD_WAS_STOPPED);
                    $task = $this->threads[$processId]['task'];
                    unset($this->threads[$processId]);
                    $this->taskManager->markRunningTaskAsAborted($task);
                } else {
                    $this->sleep(10);
                    if (!$this->hasThreadFinished($processId)) {
                        throw new RuntimeException(
                            'thread with process id "' . $processId . '" could not be stopped'
                        );
                    }
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
            $this->stopThread($newestProcessId);
        }
    }

    /**
     * @throws RuntimeException
     */
    private function stopAllThreads()
    {
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

    /**
     * @param int $steps
     */
    private function sleep($steps = 1)
    {
        $this->dispatchSignal();

        for ($iterator = 0; $iterator < $steps; ++$iterator) {
            usleep($this->numberOfMicrosecondsToCheckThreadStatus);
        }
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
        if (!is_callable(array($this, $nameOfSignalHandlerMethod))) {
            throw new InvalidArgumentException(
                'provided method name "' . $nameOfSignalHandlerMethod . '" is not available'
            );
        }

        //pcntl_signal(SIGHUP,    array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGINT,    array($this, $nameOfSignalHandlerMethod));  //shell ctrl+c
        //pcntl_signal(SIGUSR1,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGUSR2,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGQUIT,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGILL,    array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGABRT,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGFPE,    array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGSEGV,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGPIPE,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGALRM,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGTERM,   array($this, $nameOfSignalHandlerMethod));  //kill <pid>
        //pcntl_signal(SIGCHLD,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGCONT,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGTSTP,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGTTIN,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGTTOU,   array($this, $nameOfSignalHandlerMethod));
    }
    //end of posix signal handling

    /**
     * @throws RuntimeException
     */
    private function assertMandatoryPropertiesAreSet()
    {
        $properties = array(
            'eventDispatcher',
            'memoryLimitManager',
            'timeLimitManager',
            'taskManager'
        );

        foreach ($properties as $property) {
            if (is_null($this->$property)) {
                throw new RuntimeException(
                    'mandatory property "' . $property . '" not set'
                );
            }
        }
    }
}
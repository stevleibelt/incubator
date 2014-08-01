<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 31.07.2014
 */

namespace Net\Bazzline\Component\ForkManager;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class ForkManagerEvent
 * @package Net\Bazzline\Component\ForkManager
 */
class ForkManagerEvent extends Event
{
    const FINISHED_EXECUTION                    = 'forkManager.execution.finished';
    const FINISHED_EXECUTION_OF_OPEN_TASK       = 'forkManager.task.open.finished';
    const FINISHED_TASK                         = 'forkManager.task.execution.finished';
    const FINISHED_WAITING_FOR_RUNNING_TASKS    = 'forkManager.task.waiting_for_running.finished';

    const REACHING_MEMORY_LIMIT                 = 'forkManager.limit.memory.reached';
    const REACHING_TIME_LIMIT                   = 'forkManager.limit.time.reached';

    const STARTING_EXECUTION                    = 'forkManager.execution.started';
    const STARTING_EXECUTION_OF_OPEN_TASK       = 'forkManager.task.open.started';
    const STARTING_TASK                         = 'forkManager.task.execution.open.started';
    const STARTING_WAITING_FOR_RUNNING_TASKS    = 'forkManager.task.waiting_for_running.started';

    const STOPPING_TASK                         = 'forkManager.thread.stopped';

    /**
     * @var ForkManager
     */
    private $forkManager;

    /**
     * @var TaskInterface
     */
    private $task;

    public function __clone()
    {
        $this->task = null;
        $this->forkManager = null;
    }

    /**
     * @return ForkManager
     */
    public function getForkManager()
    {
        return $this->forkManager;
    }

    /**
     * @return bool
     */
    public function hasForkManager()
    {
        return ($this->forkManager instanceof ForkManager);
    }

    /**
     * @param null|ForkManager $manager
     */
    public function setForkManager(ForkManager $manager)
    {
        $this->forkManager = $manager;
    }

    /**
     * @return null|TaskInterface
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @return bool
     */
    public function hasTask()
    {
        return ($this->task instanceof TaskInterface);
    }

    /**
     * @param TaskInterface $task
     */
    public function setTask(TaskInterface $task)
    {
        $this->task = $task;
    }
}
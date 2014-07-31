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
     * @var array
     */
    private $data = array();

    public function __clone()
    {
        $this->data = array();
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return null|AbstractTask
     */
    public function getDataKeyTask()
    {
        return $this->getDataKey('task');
    }

    /**
     * @return null|ForkManager
     */
    public function getDataKeyForkManager()
    {
        return $this->getDataKey('forkManager');
    }

    public function hasDataKeyTask()
    {
        return $this->hasDataKey('task');
    }

    public function hasDataKeyForkManager()
    {
        return $this->hasDataKey('forkManager');
    }

    /**
     * @param string $key
     * @return mixed
     */
    private function getDataKey($key)
    {
        return $this->data[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    private function hasDataKey($key)
    {
        return isset($this->data[$key]);
    }
}
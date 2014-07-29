<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

namespace Net\Bazzline\Component\ForkManager;

/**
 * Class AbstractTask
 * @package Net\Bazzline\Component\Fork
 */
abstract class AbstractTask implements ExecutableInterface
{
    const STATUS_ABORTED = 2;
    const STATUS_FINISHED = 1;
    const STATUS_NOT_STARTED = 0;
    const STATUS_RUNNING = 3;

    /**
     * @var int
     */
    private $parentProcessId;

    /**
     * @var int
     */
    private $startTime = 0;

    /**
     * @var int
     */
    private $status = self::STATUS_NOT_STARTED;

    /**
     * @return int
     */
    public function getRunTime()
    {
        return (time() - $this->startTime);
    }

    /**
     * @return int
     */
    public function getMemoryUsage()
    {
        return memory_get_usage(true);
    }

    /**
     * @return int
     */
    public function getParentProcessId()
    {
        return $this->parentProcessId;
    }

    /**
     * @return int
     */
    public function getProcessId()
    {
        return getmypid();
    }

    /**
     * @return bool
     */
    public function isAborted()
    {
        return ($this->status === self::STATUS_ABORTED);
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return ($this->status === self::STATUS_FINISHED);
    }

    /**
     * @return bool
     */
    public function isNotStarted()
    {
        return ($this->status === self::STATUS_NOT_STARTED);
    }

    /**
     * @return bool
     */
    public function isRunning()
    {
        return ($this->status === self::STATUS_RUNNING);
    }

    public function markAsAborted()
    {
        $this->status = self::STATUS_ABORTED;
    }

    public function markAsFinished()
    {
        $this->status = self::STATUS_FINISHED;
    }

    public function markAsRunning()
    {
        $this->status = self::STATUS_RUNNING;
    }

    /**
     * @param int $parentProcessId
     */
    public function setParentProcessId($parentProcessId)
    {
        $this->parentProcessId = (int) $parentProcessId;
    }

    /**
     * @param int $timestamp
     */
    public function setStartTime($timestamp)
    {
        $this->startTime = (int) $timestamp;
    }
}
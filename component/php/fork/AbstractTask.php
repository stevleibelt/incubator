<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

namespace Net\Bazzline\Component\Fork;

/**
 * Class AbstractTask
 * @package Net\Bazzline\Component\Fork
 */
abstract class AbstractTask implements ExecutableInterface
{
    const STATUS_ABORTED = 2;
    const STATUS_FINISHED = 1;
    const STATUS_NOT_FINISHED = 0;
    const STATUS_RUNNING = 3;

    /**
     * @var int
     */
    private $parentProcessId;

    /**
     * @var int
     */
    private $status = self::STATUS_NOT_FINISHED;

    /**
     * @param int $parentProcessId
     */
    public function setParentProcessId($parentProcessId)
    {
        $this->parentProcessId = $parentProcessId;
    }

    /**
     * @return int
     */
    public function getParentProcessId()
    {
        return $this->parentProcessId;
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
    public function isRunning()
    {
        return ($this->status === self::STATUS_RUNNING);
    }

    /**
     * @return bool
     */
    public function isNotFinished()
    {
        return ($this->status = self::STATUS_NOT_FINISHED);
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
}
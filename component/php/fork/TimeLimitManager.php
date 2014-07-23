<?php
/**
 * @author: sleibelt
 * @since: 7/23/14
 */

namespace Net\Bazzline\Component\Fork;

/**
 * Class TimeLimitManager
 * @package Net\Bazzline\Component\Fork
 */
class TimeLimitManager
{
    /**
     * @var int
     */
    private $bufferInSeconds;

    /**
     * @var int
     */
    private $maximumInSeconds;

    /**
     * @var int
     */
    private $startTime;

    public function __construct()
    {
        $this->setMaximumInSeconds((int) ini_get('max_execution_time'));
        $this->startTime = time();
    }

    /**
     * @param int $bufferInSeconds
     */
    public function setBufferInSeconds($bufferInSeconds)
    {
        $this->bufferInSeconds = (int) $bufferInSeconds;
    }

    /**
     * @return int
     */
    public function getBufferInSeconds()
    {
        return $this->bufferInSeconds;
    }

    /**
     * @param int $maximumInSeconds
     */
    public function setMaximumInSeconds($maximumInSeconds)
    {
        $this->maximumInSeconds = time() + (int) $maximumInSeconds;
    }

    /**
     * @return int
     */
    public function getMaximumInSeconds()
    {
        return $this->maximumInSeconds;
    }


    /**
     * @return bool
     */
    public function isLimitReached()
    {
        $currentTimeWithBuffer = time() + $this->bufferInSeconds;

        $isReached = ($currentTimeWithBuffer >= $this->maximumInSeconds);

        return $isReached;
    }
} 
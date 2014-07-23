<?php
/**
 * @author: sleibelt
 * @since: 7/23/14
 */

namespace Net\Bazzline\Component\Fork;

/**
 * Class MemoryLimitManager
 * @package Net\Bazzline\Component\Fork
 */
class MemoryLimitManager
{
    /**
     * @var int
     */
    private $bufferInBits;

    /**
     * @var int
     */
    private $maximumInBits;

    /**
     * @param int $bits
     */
    public function setBufferInBits($bits)
    {
        $this->bufferInBits = (int) $bits;
    }

    /**
     * @param int $bytes
     */
    public function setBufferInBytes($bytes)
    {
        $this->setBufferInBits((8 * $bytes));
    }

    /**
     * @param int $kiloBytes
     */
    public function setBufferInKiloBytes($kiloBytes)
    {
        $this->setBufferInBytes((1024 * $kiloBytes));
    }

    /**
     * @param int $megaBytes
     */
    public function setBufferInMegaBytes($megaBytes)
    {
        $this->setBufferInKiloBytes((1024 * $megaBytes));
    }

    /**
     * @param int $bits
     */
    public function setMaximumInBits($bits)
    {
        $this->maximumInBits = (int) $bits;
    }

    /**
     * @param int $bytes
     */
    public function setMaximumInBytes($bytes)
    {
        $this->setMaximumInBits((8 * $bytes));
    }

    /**
     * @param int $kiloBytes
     */
    public function setMaximumInKiloBytes($kiloBytes)
    {
        $this->setMaximumInBytes((1024 * $kiloBytes));
    }

    /**
     * @param int $megaBytes
     */
    public function setMaximumInMegaBytes($megaBytes)
    {
        $this->setMaximumInKiloBytes((1024 * $megaBytes));
    }

    /**
     * @return bool
     */
    public function isLimitReached()
    {
        $currentUsageWithBuffer = memory_get_usage(true) + $this->bufferInBits;

        $isReached = ($currentUsageWithBuffer >= $this->maximumInBits);

        return $isReached;
    }
}
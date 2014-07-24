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
    private $bufferInBytes;

    /**
     * @var int
     */
    private $maximumInBytes;

    public function __construct()
    {
        //@todo implement dealing with memory_limit of -1
        $currentMemoryLimit = trim(ini_get('memory_limit'));
        $unitIdentifier = strtolower($currentMemoryLimit[strlen($currentMemoryLimit)-1]);

        switch ($unitIdentifier) {
            case 'G':
                $this->maximumInBytes = 1073741824 * $currentMemoryLimit;    //1073741824 = 1024 * 1024 * 1024
                break;
            case 'M':
                $this->maximumInBytes = 1048576 * $currentMemoryLimit;    //1048576 = 1024 * 1024
                break;
            case 'K':
                $this->maximumInBytes = 1024 * $currentMemoryLimit;
                break;
            default:
                $this->maximumInBytes = $currentMemoryLimit;
        }

        $this->maximumInBytes = $currentMemoryLimit;
    }

    /**
     * @param int $bytes
     */
    public function setBufferInBytes($bytes)
    {
        $this->bufferInBytes = (int) $bytes;
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
     * @param int $gigaBytes
     */
    public function setBufferInGigaBytes($gigaBytes)
    {
        $this->setBufferInMegaBytes((1024 * $gigaBytes));
    }

    /**
     * @param int $bytes
     */
    public function setMaximumInBytes($bytes)
    {
        $this->maximumInBytes = (int) $bytes;
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
     * @param int $gigaBytes
     */
    public function setMaximumInGigaBytes($gigaBytes)
    {
        $this->setMaximumInGigaBytes((1024 * $gigaBytes));
    }

    /**
     * @param array $processIds
     * @return bool
     */
    public function isLimitReached(array $processIds = array())
    {
        $currentUsageWithBuffer = memory_get_usage(true) + $this->bufferInBytes;

        foreach ($processIds as $processId) {
            $return = 0;
            exec('ps -p ' . $processId . ' -o rss', $return);

            if (isset($return[1])) {
                //non-swapped physical memory in kilo bytes
                $currentUsageWithBuffer += ($return[0] * 1024);
            }
        }

        $isReached = ($currentUsageWithBuffer >= $this->maximumInBytes);

echo '  number of threads ' . count($processIds) . PHP_EOL;
echo '  memory usage ' . (memory_get_usage(true)) . PHP_EOL;
echo '  total memory usage ' . ($currentUsageWithBuffer) . PHP_EOL;
echo '  is reached ' . var_export($isReached, true) . PHP_EOL;

        return $isReached;
    }
}
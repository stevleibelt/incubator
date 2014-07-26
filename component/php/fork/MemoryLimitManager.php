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
    private $maximumFromIniInBytes;

    /**
     * @var int
     */
    private $maximumInBytes;

    public function __construct()
    {
        //@todo implement dealing with memory_limit of -1
        $currentMemoryLimitFromIni = trim(ini_get('memory_limit'));
        $unitIdentifier = strtolower($currentMemoryLimitFromIni[strlen($currentMemoryLimitFromIni)-1]);

        switch ($unitIdentifier) {
            case 'G':
                $this->maximumInBytes = 1073741824 * $currentMemoryLimitFromIni;    //1073741824 = 1024 * 1024 * 1024
                break;
            case 'M':
                $this->maximumInBytes = 1048576 * $currentMemoryLimitFromIni;    //1048576 = 1024 * 1024
                break;
            case 'K':
                $this->maximumInBytes = 1024 * $currentMemoryLimitFromIni;
                break;
            default:
                $this->maximumInBytes = $currentMemoryLimitFromIni;
        }

        $this->maximumFromIniInBytes = $currentMemoryLimitFromIni;
        $this->maximumInBytes = $currentMemoryLimitFromIni;
    }

    /**
     * @param $bytes
     * @throws InvalidArgumentException
     */
    public function setBufferInBytes($bytes)
    {
        if ($bytes > $this->maximumFromIniInBytes) {
            throw new InvalidArgumentException(
                'provided maximum (' . $bytes .
                ') is above ini maximum (' .
                $this->maximumFromIniInBytes . ')'
            );
        }

        $this->bufferInBytes = (int) $bytes;
    }

    /**
     * @param int $kiloBytes
     * @throws InvalidArgumentException
     */
    public function setBufferInKiloBytes($kiloBytes)
    {
        $this->setBufferInBytes((1024 * $kiloBytes));
    }

    /**
     * @param int $megaBytes
     * @throws InvalidArgumentException
     */
    public function setBufferInMegaBytes($megaBytes)
    {
        $this->setBufferInKiloBytes((1024 * $megaBytes));
    }

    /**
     * @param int $gigaBytes
     * @throws InvalidArgumentException
     */
    public function setBufferInGigaBytes($gigaBytes)
    {
        $this->setBufferInMegaBytes((1024 * $gigaBytes));
    }

    /**
     * @param int $bytes
     * @throws InvalidArgumentException
     */
    public function setMaximumInBytes($bytes)
    {
        $this->maximumInBytes = (int) $bytes;
    }

    /**
     * @param int $kiloBytes
     * @throws InvalidArgumentException
     */
    public function setMaximumInKiloBytes($kiloBytes)
    {
        $this->setMaximumInBytes((1024 * $kiloBytes));
    }

    /**
     * @param int $megaBytes
     * @throws InvalidArgumentException
     */
    public function setMaximumInMegaBytes($megaBytes)
    {
        $this->setMaximumInKiloBytes((1024 * $megaBytes));
    }

    /**
     * @param int $gigaBytes
     * @throws InvalidArgumentException
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
            exec('ps -p ' . $processId . '  --no-headers -o rss', $return);

            if (isset($return[0])) {
                //non-swapped physical memory in kilo bytes
                $currentUsageWithBuffer += ($return[0] * 1024);
            }
        }

        $isReached = ($currentUsageWithBuffer >= $this->maximumInBytes);

        return $isReached;
    }
}
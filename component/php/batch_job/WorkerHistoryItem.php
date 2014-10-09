<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-10-09 
 */

namespace component\php\batch_job;

/**
 * Class WorkerHistoryItem
 * @package component\php\batch_job
 */
class WorkerHistoryItem extends WorkerListItem
{
    /**
     * @var int|float
     */
    private $memoryUsage;

    /**
     * @return null|float|int
     */
    public function getMemoryUsage()
    {
        return $this->memoryUsage;
    }

    /**
     * @param float|int $memoryUsage
     */
    public function setMemoryUsage($memoryUsage)
    {
        $this->memoryUsage = $memoryUsage;
    }
}
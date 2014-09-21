<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-21 
 */

namespace component\php\batch_job;

/**
 * Interface ProcessHistoryStorageInterface
 * @package component\php\batch_job
 */
interface ProcessHistoryStorageInterface
{
    /**
     * @param int|string $id
     * @param string $name
     * @param int $numberOfAcquiredItems
     * @param int $currentTimestamp
     * @return $this
     * @throws StorageRuntimeException
     */
    public function add($id, $name, $numberOfAcquiredItems, $currentTimestamp);

    /**
     * @param int|string $id
     * @param string $name
     * @param int|float $memoryUsage
     * @param int $currentTimestamp
     * @return $this
     * @throws StorageRuntimeException
     */
    public function update($id, $name, $memoryUsage, $currentTimestamp);
}
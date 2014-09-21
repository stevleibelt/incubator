<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-21 
 */

namespace component\php\batch_job;

/**
 * Interface ProcessListStorageInterface
 * @package component\php\batch_job
 */
interface ProcessListStorageInterface
{
    /**
     * @param int|string $id
     * @param string $name
     * @param int $numberOfAcquiredItems
     * @param int $currentTimestamp
     * @return $this
     * @throws StorageRuntimeException
     */
    public function save($id, $name, $numberOfAcquiredItems, $currentTimestamp);

    /**
     * @param $id
     * @return $this
     * @throws StorageRuntimeException
     */
    public function delete($id);
} 
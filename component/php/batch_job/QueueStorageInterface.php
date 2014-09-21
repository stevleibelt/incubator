<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-21 
 */

namespace component\php\batch_job;

/**
 * Interface QueueStorageInterface
 * @package component\php\batch_job
 */
interface QueueStorageInterface
{
    /**
     * @param int|string $id
     * @param int $numberOfItems
     * @param int $currentTimestamp
     * @return $this
     * @throws StorageRuntimeException
     */
    public function acquire($id, $numberOfItems, $currentTimestamp);

    /**
     * @param int|string $id
     * @return mixed|array
     * @throws StorageRuntimeException
     */
    public function fetch($id);

    /**
     * @param int|string $id
     * @return $this
     * @throws StorageRuntimeException
     */
    public function release($id);
} 
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-21 
 */

namespace component\php\batch_job;

/**
 * Interface WorkerHistoryStorageInterface
 * @package component\php\batch_job
 */
interface WorkerHistoryStorageInterface
{
    /**
     * @param WorkerHistoryItem $item
     * @return $this
     * @throws StorageRuntimeException
     */
    public function add(WorkerHistoryItem $item);

    /**
     * @param WorkerHistoryItem $item
     * @return $this
     * @throws StorageRuntimeException
     */
    public function update(WorkerHistoryItem $item);
}
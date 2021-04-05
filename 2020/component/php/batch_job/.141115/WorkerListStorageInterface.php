<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-21 
 */

namespace component\php\batch_job;

/**
 * Interface WorkerListStorageInterface
 * @package component\php\batch_job
 */
interface WorkerListStorageInterface
{
    /**
     * @param WorkerListItem $item
     * @return $this
     * @throws StorageRuntimeException
     */
    public function save(WorkerListItem $item);

    /**
     * @param WorkerListItem $item
     * @return $this
     * @throws StorageRuntimeException
     */
    public function delete(WorkerListItem $item);
} 
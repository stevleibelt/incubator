<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-10-09 
 */

namespace component\php\batch_job;

/**
 * Interface AcquireInterface
 * @package component\php\batch_job
 */
interface AcquireInterface
{
    /**
     * @param Batch $batch
     * @return Batch
     * @throws RuntimeException
     */
    public function acquire(Batch $batch);
} 
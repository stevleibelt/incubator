<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-10-09 
 */

namespace component\php\batch_job;

/**
 * Interface ReleaseInterface
 * @package component\php\batch_job
 */
interface ReleaseInterface
{
    /**
     * @param Batch $batch
     * @return Batch
     * @throws RuntimeException
     */
    public function release(Batch $batch);
} 
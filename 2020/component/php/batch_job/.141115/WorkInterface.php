<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-10-09 
 */

namespace component\php\batch_job;

/**
 * Interface WorkInterface
 * @package component\php\batch_job
 */
interface WorkInterface
{
    /**
     * @param Batch $batch
     * @return Batch
     * @throws RuntimeException
     */
    public function work(Batch $batch);
} 
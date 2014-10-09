<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-10-09 
 */

namespace component\php\batch_job;

/**
 * Interface EnqueueInterface
 * @package component\php\batch_job
 */
interface EnqueueInterface
{
    /**
     * @throws RuntimeException
     */
    public function enqueue();
} 
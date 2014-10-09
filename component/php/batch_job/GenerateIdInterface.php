<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-21 
 */

namespace component\php\batch_job;

/**
 * Interface GenerateIdInterface
 * @package component\php\batch_job
 */
interface GenerateIdInterface
{
    /**
     * @return int|string
     */
    public function generateId();
} 
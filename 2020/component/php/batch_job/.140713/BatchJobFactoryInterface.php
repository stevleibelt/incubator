<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-14 
 */

namespace Net\Bazzline\Component\BatchJob;

/**
 * Interface BatchJobFactoryInterface
 * @package Net\Bazzline\Component\BatchJob
 */
interface BatchJobFactoryInterface
{
    /**
     * @return BatchJobInterface
     */
    public function create();
} 
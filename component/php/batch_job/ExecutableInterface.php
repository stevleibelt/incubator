<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-13 
 */

namespace Net\Bazzline\Component\BatchJob;

/**
 * Interface ExecutableInterface
 * @package Net\Bazzline\Component\BatchJob
 */
interface ExecutableInterface
{
    /**
     * @throws RuntimeException
     */
    public function execute();
} 
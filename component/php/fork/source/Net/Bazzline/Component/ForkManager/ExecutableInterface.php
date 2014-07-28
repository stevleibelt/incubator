<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

namespace Net\Bazzline\Component\ForkManager;

/**
 * Interface ExecutableInterface
 * @package Net\Bazzline\Component\Fork
 */
interface ExecutableInterface
{
    /**
     * @throws RuntimeException
     */
    public function execute();
} 
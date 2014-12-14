<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-12-06 
 */

namespace Net\Bazzline\Component\BatchJob\Enqueuer;

use Net\Bazzline\Component\BatchJob\InvalidArgumentException;
use Net\Bazzline\Component\BatchJob\RuntimeException;

/**
 * Interface EnqueuerInterface
 * @package Net\Bazzline\Component\BatchJob\Enqueuer
 */
interface EnqueuerInterface
{
    /**
     * @return int - number of enqueued entries
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function enqueue();
} 
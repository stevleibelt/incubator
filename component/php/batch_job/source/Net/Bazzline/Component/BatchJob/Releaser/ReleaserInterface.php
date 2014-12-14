<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-12-06 
 */

namespace Net\Bazzline\Component\BatchJob\Releaser;

use Net\Bazzline\Component\BatchJob\Batch\BatchInterface;
use Net\Bazzline\Component\BatchJob\Queue\QueueInterface;
use Net\Bazzline\Component\BatchJob\InvalidArgumentException;
use Net\Bazzline\Component\BatchJob\RuntimeException;

/**
 * Interface ReleaserInterface
 * @package Net\Bazzline\Component\BatchJob\Releaser
 */
interface ReleaserInterface
{
    /**
     * @param BatchInterface $batch
     * @param QueueInterface $queue
     * @return int - number of acquired entries
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function release(BatchInterface $batch, QueueInterface $queue);
} 
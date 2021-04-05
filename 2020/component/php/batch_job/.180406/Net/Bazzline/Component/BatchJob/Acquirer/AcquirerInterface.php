<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-12-06 
 */

namespace Net\Bazzline\Component\BatchJob\Acquirer;

use Net\Bazzline\Component\BatchJob\Batch\BatchInterface;
use Net\Bazzline\Component\BatchJob\Queue\QueueInterface;
use Net\Bazzline\Component\BatchJob\InvalidArgumentException;
use Net\Bazzline\Component\BatchJob\RuntimeException;

/**
 * Interface AcquirerInterface
 * @package Net\Bazzline\Component\BatchJob\Acquirer
 */
interface AcquirerInterface
{
    /**
     * @param BatchInterface $batch
     * @param QueueInterface $queue
     * @return int - number of acquired entries
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function acquire(BatchInterface $batch, QueueInterface $queue);
} 
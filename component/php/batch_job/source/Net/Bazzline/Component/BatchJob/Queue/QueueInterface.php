<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-12-06 
 */

namespace Net\Bazzline\Component\BatchJob\Queue;

/**
 * Interface QueueInterface
 * @package Net\Bazzline\Component\BatchJob\Queue
 */
interface QueueInterface
{
    /**
     * @param int $batchId
     * @param int $limit
     * @return int - number of updated entries
     */
    public function markWithBatchId($batchId, $limit);
} 
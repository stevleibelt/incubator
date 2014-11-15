<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-13 
 */

namespace Net\Bazzline\Component\BatchJob;

use Net\Bazzline\Component\BatchJob\Manager\Configuration\BatchJobEntry;

/**
 * Interface CallableStrategyInterface
 * @package Net\Bazzline\Component\BatchJob
 */
interface CallableStrategyInterface
{
    /**
     * @param string $factoryName
     * @param int|string $chunkId
     * @param int $chunkSize
     * @throws RuntimeException
     */
    public function call($factoryName, $chunkId, $chunkSize);
} 
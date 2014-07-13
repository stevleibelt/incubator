<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-13 
 */

namespace Net\Bazzline\Component\BatchJob;

/**
 * Interface CallableStrategyInterface
 * @package Net\Bazzline\Component\BatchJob
 */
interface CallableStrategyInterface
{
    /**
     * @param string $factoryName
     * @param null|int $chunkSize
     * @param null|int $chunkId
     * @throws RuntimeException
     */
    public function call($factoryName, $chunkSize = null, $chunkId = null);
} 
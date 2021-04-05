<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-12-06 
 */

namespace Net\Bazzline\Component\BatchJob\Batch;

/**
 * Interface BatchDependentInterface
 * @package Net\Bazzline\Component\BatchJob\Batch
 */
interface BatchDependentInterface
{
    /**
     * @param BatchInterface $batch
     * @return $this
     */
    public function injectBatch(BatchInterface $batch);
} 
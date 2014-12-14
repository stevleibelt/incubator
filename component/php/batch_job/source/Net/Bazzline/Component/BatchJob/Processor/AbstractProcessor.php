<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-12-06 
 */

namespace Net\Bazzline\Component\BatchJob\Processor;

/**
 * Class AbstractProcessor
 * @package Net\Bazzline\Component\BatchJob\Processor
 */
abstract class AbstractProcessor implements ProcessorInterface
{
    /** @var BatchInterface */
    protected $batch;

    /**
     * @param BatchInterface $batch
     * @return $this
     */
    public function injectBatch(BatchInterface $batch)
    {
        $this->batch = $batch;

        return $this;
    }
}
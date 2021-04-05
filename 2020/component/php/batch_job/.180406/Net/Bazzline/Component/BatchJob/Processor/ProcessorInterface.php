<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-12-06 
 */

namespace Net\Bazzline\Component\BatchJob\Processor;

use Net\Bazzline\Component\BatchJob\Batch\BatchDependentInterface;
use Net\Bazzline\Component\BatchJob\InvalidArgumentException;
use Net\Bazzline\Component\BatchJob\RuntimeException;

/**
 * Interface ProcessorInterface
 * @package Net\Bazzline\Component\BatchJob\Processor
 */
interface ProcessorInterface extends BatchDependentInterface
{
    /**
     * @return $this
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function process();
}
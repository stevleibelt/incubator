<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-13 
 */

namespace Net\Bazzline\Component\BatchJob;

/**
 * Interface CallableStrategyDependentInterface
 * @package Net\Bazzline\Component\BatchJob
 */
interface CallableStrategyDependentInterface
{
    /**
     * @param CallableStrategyInterface $strategy
     * @return $this
     */
    public function setCallableStrategy(CallableStrategyInterface $strategy);
} 
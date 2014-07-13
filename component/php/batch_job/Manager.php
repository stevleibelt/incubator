<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-13 
 */

namespace Net\Bazzline\Component\BatchJob;

/**
 * Class Manager
 * @package Net\Bazzline\Component\BatchJob
 */
class Manager implements CallableStrategyDependentInterface, ExecutableInterface, ManagerConfigurationDependentInterface
{
    /**
     * @var ManagerConfiguration
     */
    private $configuration;

    /**
     * @var CallableStrategyInterface
     */
    private $callableStrategy;

    /**
     * @param CallableStrategyInterface $strategy
     * @return $this
     */
    public function setCallableStrategy(CallableStrategyInterface $strategy)
    {
        $this->callableStrategy = $strategy;

        return $this;
    }

    /**
     * @param ManagerConfiguration $configuration
     * @return $this
     */
    public function setManagerConfiguration(ManagerConfiguration $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @throws RuntimeException
     */
    public function execute()
    {
        // TODO: Implement execute() method.
        // need service locator or factory to get all needed batch jobs
    }
}
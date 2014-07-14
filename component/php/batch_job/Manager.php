<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-13 
 */

namespace Net\Bazzline\Component\BatchJob;

use Net\Bazzline\Component\BatchJob\Manager\Configuration\DependentInterface;
use Net\Bazzline\Component\BatchJob\Manager\Configuration;

/**
 * Class Manager
 * @package Net\Bazzline\Component\BatchJob
 */
class Manager implements CallableStrategyDependentInterface, ExecutableInterface, DependentInterface
{
    /**
     * @var CallableStrategyInterface
     */
    private $callableStrategy;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var int
     */
    private $currentTimestamp;

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
     * @param Configuration $configuration
     * @return $this
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @param int $currentTimestamp
     */
    public function setCurrentTimestamp($currentTimestamp)
    {
        $this->currentTimestamp = $currentTimestamp;
    }

    /**
     * @throws RuntimeException
     */
    public function execute()
    {
        $entries = $this->configuration->getBatchJobEntries();

        foreach ($entries as $entry) {
            $batchJob = $entry->getFactory()->create();
            $maximumNumberOfRunningBatchJobs = $entry->getMaximumNumberOfThreads();

            for ($iterator = 0; $iterator < $maximumNumberOfRunningBatchJobs; ++$iterator) {
                $chunkId = $this->currentTimestamp . '' . $iterator;

                $batchJob->setChunkId($chunkId);
                $couldAcquireChunk = $batchJob->acquireChunk();
                if ($couldAcquireChunk) {
                    $this->callableStrategy->call($entry);
                } else {
                    $iterator = $maximumNumberOfRunningBatchJobs;
                }
            }
        }
    }
}
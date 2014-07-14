<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-14 
 */

namespace Net\Bazzline\Component\BatchJob\Manager\Configuration;

/**
 * Class BatchJobEntry
 * @package Net\Bazzline\Component\BatchJob\Manager
 */
class BatchJobEntry
{
    /**
     * @var int
     */
    private $maximumNumberOfThreads;

    /**
     * @var int
     */
    private $minimumNumberOfThreads;

    /**
     * @var string
     */
    private $factory;

    /**
     * @param int $chunkSize
     * @return $this
     */
    public function setMaximumNumberOfThreads($chunkSize)
    {
        $this->maximumNumberOfThreads = (int) $chunkSize;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getMaximumNumberOfThreads()
    {
        return $this->maximumNumberOfThreads;
    }

    /**
     * @param int$chunkId
     * @return $this
     */
    public function setMinimumNumberOfThreads($chunkId)
    {
        $this->minimumNumberOfThreads = $chunkId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMinimumNumberOfThreads()
    {
        return $this->minimumNumberOfThreads;
    }

    /**
     * @param string $factory
     * @return $this
     */
    public function setFactory($factory)
    {
        $this->factory = $factory;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
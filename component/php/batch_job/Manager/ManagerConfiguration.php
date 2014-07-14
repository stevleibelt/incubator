<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-13 
 */

namespace Net\Bazzline\Component\BatchJob\Manager;

/**
 * Class ManagerConfiguration
 * @package Net\Bazzline\Component\BatchJob
 */
class ManagerConfiguration
{
    /**
     * @var array
     */
    private $batchJobEntries = array();

    /**
     * @param string $factoryName
     * @param int $maximumNumberOfThreads
     * @param int $minimumNumberOfThreads
     * @return $this
     */
    public function addBatchJobEntry($factoryName, $maximumNumberOfThreads = 100, $minimumNumberOfThreads = 1)
    {
        $this->batchJobEntries[] = array(
            'factory_name'  => $factoryName,
            'threads'       => array(
                'maximum' => $maximumNumberOfThreads,
                'minimum' => $minimumNumberOfThreads
            )
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getBatchJobEntries()
    {
        return $this->batchJobEntries;
    }
} 
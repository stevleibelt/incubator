<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-13 
 */

namespace Net\Bazzline\Component\BatchJob\Manager;

use Net\Bazzline\Component\BatchJob\Manager\Configuration\BatchJobEntry;

/**
 * Class Configuration
 * @package Net\Bazzline\Component\BatchJob
 */
class Configuration
{
    /**
     * @var array
     */
    private $batchJobEntries = array();

    /**
     * @param BatchJobEntry $entry
     * @return $this
     */
    public function addBatchJobEntry(BatchJobEntry $entry)
    {
        $this->batchJobEntries[] = $entry;

        return $this;
    }

    /**
     * @return array|BatchJobEntry[]
     */
    public function getBatchJobEntries()
    {
        return $this->batchJobEntries;
    }
} 
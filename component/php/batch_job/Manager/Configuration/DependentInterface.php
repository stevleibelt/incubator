<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-13 
 */

namespace Net\Bazzline\Component\BatchJob\Manager\Configuration;

use Net\Bazzline\Component\BatchJob\Manager\Configuration;

/**
 * Interface DependentInterface
 * @package Net\Bazzline\Component\BatchJob
 */
interface DependentInterface
{
    /**
     * @param Configuration $configuration
     * @return $this
     */
    public function setConfiguration(Configuration $configuration);
} 
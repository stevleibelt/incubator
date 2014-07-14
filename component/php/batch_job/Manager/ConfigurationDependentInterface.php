<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-13 
 */

namespace Net\Bazzline\Component\BatchJob\Manager;

/**
 * Interface ConfigurationDependentInterface
 * @package Net\Bazzline\Component\BatchJob
 */
interface ConfigurationDependentInterface
{
    /**
     * @param ManagerConfiguration $configuration
     * @return $this
     */
    public function setManagerConfiguration(ManagerConfiguration $configuration);
} 
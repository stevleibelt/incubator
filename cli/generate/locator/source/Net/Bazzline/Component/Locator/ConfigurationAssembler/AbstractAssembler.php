<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-26 
 */

namespace Net\Bazzline\Component\Locator\ConfigurationAssembler;

use Net\Bazzline\Component\Locator\Configuration;

/**
 * Class AbstractAssembler
 * @package Net\Bazzline\Component\Locator\ConfigurationAssembler
 */
abstract class AbstractAssembler implements AssemblerInterface
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @return Configuration
     * @throws RuntimeException
     */
    public function getConfiguration()
    {
        if (is_null($this->configuration)) {
            throw new RuntimeException(
                'configuration is mandatory'
            );
        }

        return $this->configuration;
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
}
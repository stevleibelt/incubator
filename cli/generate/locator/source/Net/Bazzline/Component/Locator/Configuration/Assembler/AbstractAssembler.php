<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-26 
 */

namespace Net\Bazzline\Component\Locator\Configuration\Assembler;

use Net\Bazzline\Component\Locator\Configuration;
use Net\Bazzline\Component\Locator\MethodBodyBuilder\FetchFromFactoryInstancePoolBuilder;
use Net\Bazzline\Component\Locator\MethodBodyBuilder\FetchFromSharedInstancePoolBuilder;
use Net\Bazzline\Component\Locator\MethodBodyBuilder\FetchFromSharedInstancePoolOrCreateByFactoryBuilder;
use Net\Bazzline\Component\Locator\MethodBodyBuilder\NewInstanceBuilder;

/**
 * Class AbstractAssembler
 * @package Net\Bazzline\Component\Locator\Configuration\Assembler
 */
abstract class AbstractAssembler implements AssemblerInterface
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var FetchFromFactoryInstancePoolBuilder
     */
    private $fetchFromFactoryInstancePoolBuilder;

    /**
     * @var FetchFromSharedInstancePoolBuilder
     */
    private $fetchFromSharedInstancePoolBuilder;

    /**
     * @var FetchFromSharedInstancePoolOrCreateByFactoryBuilder
     */
    private $fetchFromSharedInstancePoolOrCreateByFactoryBuilder;

    /**
     * @var NewInstanceBuilder
     */
    private $newInstanceBuilder;

    /**
     * @return Configuration
     * @throws RuntimeException
     */
    final public function getConfiguration()
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
    final public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @param FetchFromFactoryInstancePoolBuilder $fetchFromFactoryInstancePoolBuilder
     * @return $this
     */
    public function setFetchFromFactoryInstancePoolBuilder(FetchFromFactoryInstancePoolBuilder $fetchFromFactoryInstancePoolBuilder)
    {
        $this->fetchFromFactoryInstancePoolBuilder = $fetchFromFactoryInstancePoolBuilder;

        return $this;
    }

    /**
     * @param FetchFromSharedInstancePoolBuilder $fetchFromSharedInstancePoolBuilder
     * @return $this
     */
    public function setFetchFromSharedInstancePoolBuilder(FetchFromSharedInstancePoolBuilder $fetchFromSharedInstancePoolBuilder)
    {
        $this->fetchFromSharedInstancePoolBuilder = $fetchFromSharedInstancePoolBuilder;

        return $this;
    }

    /**
     * @param FetchFromSharedInstancePoolOrCreateByFactoryBuilder $fetchFromSharedInstancePoolOrCreateByFactoryBuilder
     * @return $this
     */
    public function setFetchFromSharedInstancePoolOrCreateByFactoryBuilder(FetchFromSharedInstancePoolOrCreateByFactoryBuilder $fetchFromSharedInstancePoolOrCreateByFactoryBuilder)
    {
        $this->fetchFromSharedInstancePoolOrCreateByFactoryBuilder = $fetchFromSharedInstancePoolOrCreateByFactoryBuilder;

        return $this;
    }

    /**
     * @param NewInstanceBuilder $newInstanceBuilder
     * @return $this
     */
    public function setNewInstanceBuilder(NewInstanceBuilder $newInstanceBuilder)
    {
        $this->newInstanceBuilder = $newInstanceBuilder;

        return $this;
    }

    /**
     * @param mixed $data
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    final public function assemble($data)
    {
        $this->assertMandatoryProperties();
        $this->validateData($data);
        $this->map($data);
    }

    /**
     * @param mixed $data
     * @throws RuntimeException
     */
    abstract protected function map($data);

    /**
     * @param mixed $data
     * @throws InvalidArgumentException
     */
    abstract protected function validateData($data);

    /**
     * @return FetchFromFactoryInstancePoolBuilder
     */
    protected function getNewFetchFromFactoryInstancePoolBuilder()
    {
        return clone $this->fetchFromFactoryInstancePoolBuilder;
    }

    /**
     * @return FetchFromSharedInstancePoolBuilder
     */
    protected function getFetchFromSharedInstancePoolBuilder()
    {
        return clone $this->fetchFromSharedInstancePoolBuilder;
    }

    /**
     * @return FetchFromSharedInstancePoolOrCreateByFactoryBuilder
     */
    protected function getFetchFromSharedInstancePoolOrCreateByFactoryBuilder()
    {
        return clone $this->fetchFromSharedInstancePoolOrCreateByFactoryBuilder;
    }

    /**
     * @return NewInstanceBuilder
     */
    protected function getNewInstanceBuilder()
    {
        return clone $this->newInstanceBuilder;
    }

    /**
     * @param array $data
     * @param array $mandatoryKeysToExpectedValueType
     * @throws InvalidArgumentException
     */
    final protected function validateDataWithMandatoryKeysAndExpectedValueType(array $data, array $mandatoryKeysToExpectedValueType)
    {
        foreach ($mandatoryKeysToExpectedValueType as $mandatoryKey => $expectedType) {
            if (!isset($data[$mandatoryKey])) {
                throw new InvalidArgumentException(
                    'data array must contain content for key "' . $mandatoryKey . '"'
                );
            }
            $exceptionMessage = 'value of key "' . $mandatoryKey . '" must be of type "' . $expectedType . '"';

            switch ($expectedType) {
                case 'array':
                    if (!is_array($data[$mandatoryKey])) {
                        throw new InvalidArgumentException(
                            $exceptionMessage
                        );
                    }
                    break;
                case 'string':
                    if (!is_string($data[$mandatoryKey])) {
                        throw new InvalidArgumentException(
                            $exceptionMessage
                        );
                    }
                    break;
            }
        }
    }

    /**
     * @throws RuntimeException
     */
    private function assertMandatoryProperties()
    {
        $propertyNames = array(
            'configuration',
            'fetchFromFactoryInstancePoolBuilder',
            'fetchFromSharedInstancePoolBuilder',
            'fetchFromSharedInstancePoolOrCreateByFactoryBuilder',
            'newInstanceBuilder'
        );

        foreach ($propertyNames as $propertyName) {
            if (is_null($this->configuration)) {
                throw new RuntimeException(
                    $propertyName . ' is mandatory'
                );
            }
        }
    }
}
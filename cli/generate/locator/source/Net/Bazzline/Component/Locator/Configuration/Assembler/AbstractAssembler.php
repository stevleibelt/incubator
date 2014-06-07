<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-26 
 */

namespace Net\Bazzline\Component\Locator\Configuration\Assembler;

use Net\Bazzline\Component\Locator\Configuration;

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
     * @param mixed $data
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    final public function assemble($data)
    {
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
}
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-26 
 */

namespace Net\Bazzline\Component\Locator\ConfigurationAssembler;

/**
 * Class FromArrayAssembler
 * @package Net\Bazzline\Component\Locator\ConfigurationAssembler
 */
class FromArrayAssembler extends AbstractAssembler
{
    /**
     * @param mixed $data
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function assemble($data)
    {
        $this->validateData($data);
        $this->map($data);
    }

    /**
     * @param array $data
     * @throws RuntimeException
     */
    private function map(array $data)
    {
        $configuration = $this->getConfiguration();

        //set strings
        $configuration
            ->setName($data['class_name'])
            ->setFilePath($data['file_path'])
            ->setName($data['name'])
            ->setNamespace($data['namespace'])
            ->setParentClassName($data['parent_class_name']);

        //set arrays
        foreach ($data['shared_instance'] as $alias => $fullQualifiedClassName) {
            $configuration->addSharedInstance($fullQualifiedClassName, $alias);
        }

        foreach ($data['single_instance'] as $alias => $fullQualifiedClassName) {
            $configuration->addSingleInstance($fullQualifiedClassName, $alias);
        }

        $this->setConfiguration($configuration);
    }

    /**
     * @param $data
     * @throws InvalidArgumentException
     */
    private function validateData($data)
    {
        if (!is_array($data)) {
            throw new InvalidArgumentException(
                'data must be an array'
            );
        }

        if (empty($data)) {
            throw new InvalidArgumentException(
                'data array must contain content'
            );
        }

        $mandatoryKeysToExpectedTyp = array(
            'class_name'        => 'string',
            'file_path'         => 'string',
            'name'              => 'string',
            'namespace'         => 'string',
            'parent_class_name' => 'string',
            'shared_instance'   => 'array',
            'single_instance'   => 'array'
        );

        foreach ($mandatoryKeysToExpectedTyp as $mandatoryKey => $expectedType) {
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
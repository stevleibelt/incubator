<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-26 
 */

namespace Net\Bazzline\Component\Locator\Configuration;

/**
 * Class FromArrayAssembler
 * @package Net\Bazzline\Component\Locator\Configuration
 */
class FromArrayAssembler extends AbstractAssembler
{
    /**
     * @param mixed $data
     * @throws RuntimeException
     */
    protected function map($data)
    {
        $configuration = $this->getConfiguration();

        //set strings
        $configuration
            ->setFilePath($data['file_path'])
            ->setName($data['name'])
            ->setNamespace($data['namespace']);

        //set arrays
        foreach ($data['extends'] as $className) {
            $configuration->addExtends($className);
        }

        foreach ($data['instances'] as $key => $instance) {
            if (!isset($instance['class'])) {
                throw new RuntimeException(
                    'instance entry with key "' . $key . '" needs to have a key "class"'
                );
            }

            $alias = (isset($instance['alias'])) ? $instance['alias'] : '';
            $class = $instance['class'];
            $isFactory = (isset($instance['is_factory'])) ? $instance['is_factory'] : false;
            $isShared = (isset($instance['is_shared'])) ? $instance['is_shared'] : true;

            $configuration->addInstance($class, $isFactory, $isShared, $alias);
        }

        foreach ($data['implements'] as $interfaceName) {
            $configuration->addImplements($interfaceName);
        }

        foreach ($data['uses'] as $key => $uses) {
            if (!isset($uses['class'])) {
                throw new RuntimeException(
                    'use entry with key "' . $key . '" needs to have a key "class"'
                );
            }

            $alias = (isset($uses['alias'])) ? $uses['alias'] : '';
            $class = $uses['class'];

            $configuration->addUses($class, $alias);
        }

        $this->setConfiguration($configuration);
    }

    /**
     * @param mixed $data
     * @throws InvalidArgumentException
     */
    protected function validateData($data)
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
            'extends'           => 'array',
            'file_path'         => 'string',
            'instances'         => 'array',
            'implements'        => 'array',
            'name'              => 'string',
            'namespace'         => 'string',
            'uses'              => 'array'
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
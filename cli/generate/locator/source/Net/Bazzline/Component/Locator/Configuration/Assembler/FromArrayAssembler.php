<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-26 
 */

namespace Net\Bazzline\Component\Locator\Configuration\Assembler;

/**
 * Class FromArrayAssembler
 * @package Net\Bazzline\Component\Locator\Configuration\Assembler
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
            ->setClassName($data['class_name'])
            ->setFilePath($data['file_path'])
            ->setMethodPrefix($data['method_prefix'])
            ->setNamespace($data['namespace']);

        //set arrays
        foreach ($data['extends'] as $className) {
            $configuration->setExtends($className);
        }

        foreach ($data['instances'] as $key => $instance) {
            if (!isset($instance['class_name'])) {
                throw new RuntimeException(
                    'instance entry with key "' . $key . '" needs to have a key "class_name"'
                );
            }

            $alias = (isset($instance['alias'])) ? $instance['alias'] : null;
            $class = $instance['class_name'];
            $isFactory = (isset($instance['is_factory'])) ? $instance['is_factory'] : false;
            $isShared = (isset($instance['is_shared'])) ? $instance['is_shared'] : true;

            $configuration->addInstance($class, $isFactory, $isShared, $alias);
        }

        foreach ($data['implements'] as $interfaceName) {
            $configuration->addImplements($interfaceName);
        }

        foreach ($data['uses'] as $key => $uses) {
            if (!isset($uses['class_name'])) {
                throw new RuntimeException(
                    'use entry with key "' . $key . '" needs to have a key "class_name"'
                );
            }

            $alias = (isset($uses['alias'])) ? $uses['alias'] : '';
            $class = $uses['class_name'];

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

        $mandatoryKeysToExpectedValueTyp = array(
            'class_name'        => 'string',
            'extends'           => 'array',
            'file_path'         => 'string',
            'instances'         => 'array',
            'implements'        => 'array',
            'namespace'         => 'string',
            'uses'              => 'array'
        );

        $this->validateDataWithMandatoryKeysAndExpectedValueType(
            $data,
            $mandatoryKeysToExpectedValueTyp
        );
    }
}
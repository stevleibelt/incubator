<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-26 
 */

namespace Net\Bazzline\Component\Locator\Configuration\Assembler;

/**
 * Class FromPropelSchemaXmlFileAssembler
 * @package Net\Bazzline\Component\Locator\Configuration\Assembler
 */
class FromPropelSchemaXmlFileAssembler extends AbstractAssembler
{
    /**
     * @param mixed $data
     * @throws RuntimeException
     */
    protected function map($data)
    {
        $configuration = $this->getConfiguration();
        $configurationFileData = $data['configuration_file'];
        $schemaXmlData = $data['schema_xml'];

        //set strings
        $configuration
            ->setClassName($configurationFileData['class_name'])
            ->setFilePath($configurationFileData['file_path'])
            ->setMethodPrefix($configurationFileData['method_prefix'])
            ->setNamespace($configurationFileData['namespace']);

        //set arrays
        foreach ($configurationFileData['extends'] as $className) {
            $configuration->setExtends($className);
        }

        //@todo implement instance adding
echo var_export($schemaXmlData, true) . PHP_EOL;

        foreach ($configurationFileData['implements'] as $interfaceName) {
            $configuration->addImplements($interfaceName);
        }

        foreach ($configurationFileData['uses'] as $key => $uses) {
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
            'configuration_file'    => 'array',
            'schema_xml'            => 'array'
        );

        $this->validateDataWithMandatoryKeysAndExpectedValueType(
            $data,
            $mandatoryKeysToExpectedValueTyp
        );

        $mandatoryConfigurationFileKeysToExpectedValueTyp = array(
            'class_name'        => 'string',
            'extends'           => 'array',
            'file_path'         => 'string',
            'implements'        => 'array',
            'namespace'         => 'string',
            'uses'              => 'array'
        );

        $this->validateDataWithMandatoryKeysAndExpectedValueType(
            $data['configuration_file'],
            $mandatoryConfigurationFileKeysToExpectedValueTyp
        );
    }
}
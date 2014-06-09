<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-26 
 */

namespace Net\Bazzline\Component\Locator\Configuration\Assembler;

use XMLReader;

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
        $pathToSchemaXml = realpath($data['path_to_schema_xml']);

        if (!is_file($pathToSchemaXml)) {
            throw new RuntimeException(
                'provided schema xml path "' . $pathToSchemaXml . '" is not a file'
            );
        }

        if (!is_readable($pathToSchemaXml)) {
            throw new RuntimeException(
                'file "' . $pathToSchemaXml . '" is not readable'
            );
        }

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

        //@todo implement instance adding
        $reader = new XMLReader();
        $reader->open($pathToSchemaXml);

        $databaseNamespace = '';
        $name = '';
        $namespace = '';
        $package = '';
        $phpName = '';

        while ($reader->read()) {
            switch ($reader->nodeType) {
                case XMLREADER::ELEMENT:
                    if ($reader->name === 'database') {
                        $databaseNamespace = $reader->getAttribute('namespace');
                    }
                    if ($reader->name === 'table') {
                        $name = $reader->getAttribute('name');
                        $namespace = $reader->getAttribute('namespace');
                        $package = $reader->getAttribute('package');
                        $phpName = $reader->getAttribute('phpName');
                    }
                    echo 'database namespace: ' . $databaseNamespace . PHP_EOL;
                    echo 'name: ' . $name . PHP_EOL;
                    echo 'namespace: ' . $namespace . PHP_EOL;
                    echo 'package: ' . $package . PHP_EOL;
                    echo 'php name: ' . $phpName . PHP_EOL;
            }
        }
        $reader->close();

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
exit('----') . PHP_EOL;
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
            'class_name'            => 'string',
            'extends'               => 'array',
            'file_path'             => 'string',
            'implements'            => 'array',
            'namespace'             => 'string',
            'path_to_schema_xml'    => 'string',
            'uses'                  => 'array'
        );

        $this->validateDataWithMandatoryKeysAndExpectedValueType(
            $data,
            $mandatoryKeysToExpectedValueTyp
        );
    }
}
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-26 
 */

namespace Net\Bazzline\Component\Locator\Configuration\Assembler;

use XMLReader;

/**
 * Class FromPropelSchemaXmlAssembler
 * @package Net\Bazzline\Component\Locator\Configuration\Assembler
 */
class FromPropelSchemaXmlAssembler extends AbstractAssembler
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

        $hasRootNamespace = false;
        $name = '';
        $namespace = '';
        $phpName = '';
        $rootNamespace = '';

        while ($reader->read()) {
            if ($reader->nodeType === XMLREADER::ELEMENT) {
                $isTableNode = false;

                if ($reader->name === 'database') {
                    $rootNamespace = $reader->getAttribute('namespace');
                    if (strlen($rootNamespace) > 0) {
                        $hasRootNamespace = true;
                    }
                }
   
                if ($reader->name === 'table') {
                    $alias = '';
                    $class = '';
                    $isTableNode = true;
                    $namespace = $reader->getAttribute('namespace');
                    $phpName = $reader->getAttribute('phpName');
                    $tableName = $reader->getAttribute('name');

                    $name = (strlen($phpName) > 0) ? $phpName : $tableName;

                    if ($hasRootNamespace) {
                        $class .= $rootNamespace . '\\';
                    }
                    if (strlen($namespace) > 0) {
                        $class .= $namespace . '\\';
                    }
                    if (strlen($phpName)) {
                        $alias = $phpName;
                    }
                    $tableNameAsArray = explode('_', $tableName);
                    array_walk($tableNameAsArray, function (&$value) { $value = ucfirst($value); });
                    $class .= implode('', $tableNameAsArray);
                    $queryAlias = (strlen($alias) > 0) ? $alias . 'Query' : '';
                    $queryClass = $class . 'Query';

                    $configuration->addInstance($class, false, false, $alias);
                    $configuration->addInstance($queryClass, false, false, $queryAlias);
                }
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

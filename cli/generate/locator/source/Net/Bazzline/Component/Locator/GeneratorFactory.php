<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-26 
 */

namespace Net\Bazzline\Component\Locator;

use Net\Bazzline\Component\CodeGenerator\Factory\BlockGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\ClassGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\DocumentationGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\FileGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\MethodGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\PropertyGeneratorFactory;

/**
 * Class GeneratorFactory
 * @package Net\Bazzline\Component\Locator
 */
class GeneratorFactory
{
    /**
     * @return Generator
     */
    public function create()
    {
        $generator = new Generator();

        $blockGeneratorFactory = new BlockGeneratorFactory();
        $classGeneratorFactory = new ClassGeneratorFactory();
        $documentationGeneratorFactory = new DocumentationGeneratorFactory();
        $fileGeneratorFactory = new FileGeneratorFactory();
        $methodGeneratorFactory = new MethodGeneratorFactory();
        $propertyGeneratorFactory = new PropertyGeneratorFactory();

        $generator
            ->setBlockGeneratorFactory($blockGeneratorFactory)
            ->setClassGeneratorFactory($classGeneratorFactory)
            ->setDocumentationGeneratorFactory($documentationGeneratorFactory)
            ->setFileGeneratorFactory($fileGeneratorFactory)
            ->setMethodGeneratorFactory($methodGeneratorFactory)
            ->setPropertyGeneratorFactory($propertyGeneratorFactory);

        return $generator;
    }
} 
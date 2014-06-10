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
 * Class LocatorGeneratorFactory
 * @package Net\Bazzline\Component\Locator
 */
class LocatorGeneratorFactory
{
    /**
     * @return LocatorGenerator
     */
    public function create()
    {
        $generator = new LocatorGenerator();
        $generator
            ->setBlockGeneratorFactory(new BlockGeneratorFactory())
            ->setClassGeneratorFactory(new ClassGeneratorFactory())
            ->setDocumentationGeneratorFactory(new DocumentationGeneratorFactory())
            ->setFileGeneratorFactory(new FileGeneratorFactory())
            ->setMethodGeneratorFactory(new MethodGeneratorFactory())
            ->setPropertyGeneratorFactory(new PropertyGeneratorFactory());

        return $generator;
    }
} 
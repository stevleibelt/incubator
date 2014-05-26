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
            ->setBlockFactory(new BlockGeneratorFactory())
            ->setClassFactory(new ClassGeneratorFactory())
            ->setDocumentationFactory(new DocumentationGeneratorFactory())
            ->setFileFactory(new FileGeneratorFactory())
            ->setMethodFactory(new MethodGeneratorFactory())
            ->setPropertyFactory(new PropertyGeneratorFactory());

        return $generator;
    }
} 
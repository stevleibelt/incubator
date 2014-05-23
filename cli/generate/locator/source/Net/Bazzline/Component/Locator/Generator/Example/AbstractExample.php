<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-24 
 */

namespace Net\Bazzline\Component\Locator\Generator\Example;

use Net\Bazzline\Component\Locator\Generator\Factory\ClassGeneratorFactory;
use Net\Bazzline\Component\Locator\Generator\Factory\DocumentationGeneratorFactory;
use Net\Bazzline\Component\Locator\Generator\Factory\MethodGeneratorFactory;
use Net\Bazzline\Component\Locator\Generator\Factory\PropertyGeneratorFactory;
use Net\Bazzline\Component\Locator\Generator\Indention;

/**
 * Class AbstractExample
 * @package Net\Bazzline\Component\Locator\Generator\Example
 */
abstract class AbstractExample
{
    /**
     * @return mixed
     */
    abstract function demonstrate();

    /**
     * @return ClassGeneratorFactory
     */
    final protected function getClassGeneratorFactory()
    {
        return new ClassGeneratorFactory();
    }

    /**
     * @return DocumentationGeneratorFactory
     */
    final protected function getDocumentationGeneratorFactory()
    {
        return new DocumentationGeneratorFactory();
    }

    /**
     * @return Indention
     */
    final protected function getIndention()
    {
        return new Indention();
    }

    /**
     * @return MethodGeneratorFactory
     */
    final protected function getMethodGeneratorFactory()
    {
        return new MethodGeneratorFactory();
    }

    /**
     * @return PropertyGeneratorFactory
     */
    final protected function getPropertyGeneratorFactory()
    {
        return new PropertyGeneratorFactory();
    }
} 
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator;

use Net\Bazzline\Component\Locator\Generator\Content\Block;
use Net\Bazzline\Component\Locator\Generator\Content\Line;
use Net\Bazzline\Component\Locator\Generator\Template\ClassTemplate;
use Net\Bazzline\Component\Locator\Generator\Template\ConstantTemplate;
use Net\Bazzline\Component\Locator\Generator\Template\MethodTemplate;
use Net\Bazzline\Component\Locator\Generator\Template\PhpDocumentationTemplate;
use Net\Bazzline\Component\Locator\Generator\Template\PropertyTemplate;
use Net\Bazzline\Component\Locator\Generator\Template\TraitTemplate;
use PHPUnit_Framework_TestCase;
use Mockery;

/**
 * Class GeneratorTestCase
 * @package Test\Net\Bazzline\Component\Locator\Generator
 */
class GeneratorTestCase extends PHPUnit_Framework_TestCase
{
    //----begin of general----
    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * @param string $fullQualifiedClassName
     * @return Mockery\MockInterface
     */
    protected function getMockeryMock($fullQualifiedClassName)
    {
        return Mockery::mock($fullQualifiedClassName);
    }
    //----end of general----

    //----begin of content----
    /**
     * @return Block
     */
    protected function getBlock()
    {
        return new Block();
    }

    /**
     * @return Line
     */
    protected function getLine()
    {
        return new Line();
    }
    //----end of content----

    //----begin of template----
    /**
     * @return ClassTemplate
     */
    protected function getClassTemplate()
    {
        return new ClassTemplate();
    }

    /**
     * @return ConstantTemplate
     */
    protected function getConstantTemplate()
    {
        return new ConstantTemplate();
    }

    /**
     * @return MethodTemplate
     */
    protected function getMethodTemplate()
    {
        return new MethodTemplate();
    }

    /**
     * @return PhpDocumentationTemplate
     */
    protected function getPhpDocumentationTemplate()
    {
        return new PhpDocumentationTemplate();
    }

    /**
     * @return PropertyTemplate
     */
    protected function getPropertyTemplate()
    {
        return new PropertyTemplate();
    }

    /**
     * @return TraitTemplate
     */
    protected function getTraitTemplate()
    {
        return new TraitTemplate();
    }
    //----end of template----
}
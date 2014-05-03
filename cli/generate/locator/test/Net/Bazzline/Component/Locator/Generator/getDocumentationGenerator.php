<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator;

use Net\Bazzline\Component\Locator\Generator\Content\Block;
use Net\Bazzline\Component\Locator\Generator\Content\Line;
use Net\Bazzline\Component\Locator\Generator\ClassGenerator;
use Net\Bazzline\Component\Locator\Generator\ConstantGenerator;
use Net\Bazzline\Component\Locator\Generator\MethodGenerator;
use Net\Bazzline\Component\Locator\Generator\DocumentationGenerator;
use Net\Bazzline\Component\Locator\Generator\PropertyGenerator;
use Net\Bazzline\Component\Locator\Generator\GeneratorInterface;
use Net\Bazzline\Component\Locator\Generator\TraitGenerator;
use PHPUnit_Framework_TestCase;
use Mockery;

/**
 * Class GeneratorTestCase
 * @package Test\Net\Bazzline\Component\Locator\LocatorGenerator
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

    /**
     * @param GeneratorInterface $template
     */
    protected function debugTemplate(GeneratorInterface $template)
    {
        echo PHP_EOL . '----' . PHP_EOL . $template->andConvertToString() . PHP_EOL . '----' . PHP_EOL;
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
     * @return ClassGenerator
     */
    protected function getClassGenerator()
    {
        return new ClassGenerator();
    }

    /**
     * @return ConstantGenerator
     */
    protected function getConstantGenerator()
    {
        return new ConstantGenerator();
    }

    /**
     * @return MethodGenerator
     */
    protected function getMethodGenerator()
    {
        return new MethodGenerator();
    }

    /**
     * @return DocumentationGenerator
     */
    protected function getPhpDocumentationTemplate()
    {
        return new DocumentationGenerator();
    }

    /**
     * @return PropertyGenerator
     */
    protected function getPropertyTemplate()
    {
        return new PropertyGenerator();
    }

    /**
     * @return TraitGenerator
     */
    protected function getTraitTemplate()
    {
        return new TraitGenerator();
    }
    //----end of template----
}
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator;

use Net\Bazzline\Component\Locator\Generator\BlockGenerator;
use Net\Bazzline\Component\Locator\Generator\ClassGenerator;
use Net\Bazzline\Component\Locator\Generator\ConstantGenerator;
use Net\Bazzline\Component\Locator\Generator\DocumentationGenerator;
use Net\Bazzline\Component\Locator\Generator\GeneratorInterface;
use Net\Bazzline\Component\Locator\Generator\Indention;
use Net\Bazzline\Component\Locator\Generator\LineGenerator;
use Net\Bazzline\Component\Locator\Generator\MethodGenerator;
use Net\Bazzline\Component\Locator\Generator\PropertyGenerator;
use Net\Bazzline\Component\Locator\Generator\TraitGenerator;
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
     * @return Indention
     */
    protected function getIndention()
    {
        return new Indention();
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
    protected function debugGenerator(GeneratorInterface $template)
    {
        echo PHP_EOL . '----' . PHP_EOL . $template->generate() . PHP_EOL . '----' . PHP_EOL;
    }
    //----end of general----

    //----begin of generator----
    /**
     * @return BlockGenerator
     */
    protected function getBlockGenerator()
    {
        return new BlockGenerator($this->getIndention());
    }

    /**
     * @return LineGenerator
     */
    protected function getLineGenerator()
    {
        return new LineGenerator($this->getIndention());
    }

    /**
     * @return ClassGenerator
     */
    protected function getClassGenerator()
    {
        return new ClassGenerator($this->getIndention());
    }

    /**
     * @return ConstantGenerator
     */
    protected function getConstantGenerator()
    {
        return new ConstantGenerator($this->getIndention());
    }

    /**
     * @return MethodGenerator
     */
    protected function getMethodGenerator()
    {
        return new MethodGenerator($this->getIndention());
    }

    /**
     * @return DocumentationGenerator
     */
    protected function getDocumentationGenerator()
    {
        return new DocumentationGenerator($this->getIndention());
    }

    /**
     * @return PropertyGenerator
     */
    protected function getPropertyGenerator()
    {
        return new PropertyGenerator($this->getIndention());
    }

    /**
     * @return TraitGenerator
     */
    protected function getTraitGenerator()
    {
        return new TraitGenerator($this->getIndention());
    }
    //----end of generator----
}
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-26 
 */

namespace Test\Net\Bazzline\Component\Locator;

/**
 * Class GeneratorTest
 * @package Test\Net\Bazzline\Component\Locator
 */
class GeneratorTest extends LocatorTestCase
{
    public function testSetters()
    {
        $generator = $this->getGenerator();

        $this->assertEquals($generator, $generator->setFactoryInterfaceGenerator($this->getMockOfFactoryInterfaceGenerator()));
        $this->assertEquals($generator, $generator->setInvalidArgumentExceptionGenerator($this->getMockOfInvalidArgumentExceptionGenerator()));
        $this->assertEquals($generator, $generator->setLocatorGenerator($this->getMockOfLocatorGenerator()));
    }

    public function testGenerate()
    {
        $generator = $this->getGenerator();
        $factoryInterfaceGenerator = $this->getFactoryInterfaceGenerator();
        $invalidArgumentExceptionGenerator = $this->getInvalidArgumentExceptionGenerator();

    }
}
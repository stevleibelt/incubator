<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-09 
 */

namespace Test\Net\Bazzline\Component\Locator;

/**
 * Class LocatorGeneratorTest
 * @package Test\Net\Bazzline\Component\Locator
 */
class LocatorGeneratorTest extends LocatorTestCase
{
    public function testSetBlockGeneratorFactory()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setBlockGeneratorFactory($this->getBlockGeneratorFactory())
        );
    }

    public function testSetClassGeneratorFactory()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setClassGeneratorFactory($this->getClassGeneratorFactory())
        );
    }

    public function testSetConfiguration()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setConfiguration($this->getConfiguration())
        );
    }

    public function testSetDocumentationGeneratorFactory()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setDocumentationGeneratorFactory($this->getDocumentationGeneratorFactory())
        );
    }

    public function testSetFileGeneratorFactory()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setFileGeneratorFactory($this->getFileGeneratorFactory())
        );
    }

    public function testSetFileExistsStrategy()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setFileExistsStrategy($this->getDeleteStrategy())
        );
    }

    public function testSetMethodGeneratorFactory()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setMethodGeneratorFactory($this->getMethodGeneratorFactory())
        );
    }

    public function testSetPropertyGeneratorFactory()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setPropertyGeneratorFactory($this->getPropertyGeneratorFactory())
        );
    }

    public function testGenerate()
    {
        $this->markTestIncomplete();
        //setup vfs
        //create configuration
        //define mocks with all "shouldReceive" calls
        //inject needed mocks
        //@todo refactor test above and replace real classes with mocks
        //generate locator
        //try to create testCases to easy up testing multiple configurations (with namespace, without, etc.)
    }
}

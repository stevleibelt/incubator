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
    public function testSetBlockFactory()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setBlockFactory($this->getBlockGeneratorFactory())
        );
    }

    public function testSetClassFactory()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setClassFactory($this->getClassGeneratorFactory())
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

    public function testSetDocumentationFactory()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setDocumentationFactory($this->getDocumentationGeneratorFactory())
        );
    }

    public function testSetFileFactory()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setFileFactory($this->getFileGeneratorFactory())
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

    public function testSetMethodFactory()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setMethodFactory($this->getMethodGeneratorFactory())
        );
    }

    public function testSetPropertyFactory()
    {
        $generator = $this->getLocatorGenerator();

        $this->assertEquals(
            $generator,
            $generator->setPropertyFactory($this->getPropertyGeneratorFactory())
        );
    }

    public function testGenerate()
    {
        $this->markTestIncomplete();
        //setup vfs
        //inject needed mocks
        //@todo refactor test above and replace real classes with mocks
        //generate locator
        //compare with heredoc written expected file content
    }
}
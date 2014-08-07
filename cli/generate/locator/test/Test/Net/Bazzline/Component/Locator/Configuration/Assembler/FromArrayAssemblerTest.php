<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-09 
 */

namespace Test\Net\Bazzline\Component\Locator\Configuration\Assembler;

use Test\Net\Bazzline\Component\Locator\LocatorTestCase;

/**
 * Class FromArrayAssemblerTest
 * @package Test\Net\Bazzline\Component\Locator\Configuration\Assembler
 */
class FromArrayAssemblerTest extends LocatorTestCase
{
    /**
     * @expectedException \Net\Bazzline\Component\Locator\Configuration\Assembler\RuntimeException
     * @expectedExceptionMessage configuration is mandatory
     */
    public function testAssembleMissingProperties()
    {
        $assembler = $this->getFromArrayAssembler();

        $assembler->assemble(null);
    }

    /**
     * @expectedException \Net\Bazzline\Component\Locator\Configuration\Assembler\InvalidArgumentException
     * @expectedExceptionMessage data must be an array
     */
    public function testAssembleWithNoArrayAsData()
    {
        $assembler = $this->getFromArrayAssembler();
        $configuration = $this->getMockOfConfiguration();

        $assembler->setConfiguration($configuration)
            ->assemble(null);
    }

    /**
     * @expectedException \Net\Bazzline\Component\Locator\Configuration\Assembler\InvalidArgumentException
     * @expectedExceptionMessage data array must contain content
     */
    public function testAssembleWithEmptyDataArray()
    {
        $assembler = $this->getFromArrayAssembler();
        $configuration = $this->getMockOfConfiguration();

        $assembler->setConfiguration($configuration)
            ->assemble(array());
    }

    /**
     * @expectedException \Net\Bazzline\Component\Locator\Configuration\Assembler\InvalidArgumentException
     * @expectedExceptionMessage data array must contain content for key "class_name"
     */
    public function testAssembleWithMissingMandatoryDataKeyClassName()
    {
        $assembler = $this->getFromArrayAssembler();
        $configuration = $this->getMockOfConfiguration();

        $assembler->setConfiguration($configuration)
            ->assemble(array('key' => null));
    }

    /**
     * @expectedException \Net\Bazzline\Component\Locator\Configuration\Assembler\InvalidArgumentException
     * @expectedExceptionMessage value of key "class_name" must be of type "string"
     */
    public function testAssembleWithWrongMandatoryDataKeyClassNameValueType()
    {
        $assembler = $this->getFromArrayAssembler();
        $configuration = $this->getMockOfConfiguration();

        $assembler->setConfiguration($configuration)
            ->assemble(array('class_name' => 1));
    }

    /**
     * @expectedException \Net\Bazzline\Component\Locator\Configuration\Assembler\InvalidArgumentException
     * @expectedExceptionMessage data array must contain content for key "file_path"
     */
    public function testAssembleWithMissingMandatoryDataKeyFilePath()
    {
        $assembler = $this->getFromArrayAssembler();
        $configuration = $this->getMockOfConfiguration();

        $assembler->setConfiguration($configuration)
            ->assemble(array('class_name' => 'class name'));
    }

    /**
     * @expectedException \Net\Bazzline\Component\Locator\Configuration\Assembler\InvalidArgumentException
     * @expectedExceptionMessage value of key "extends" must be of type "array" when set
     */
    public function testAssembleWithWrongOptionalDataKeyClassNameValueType()
    {
        $assembler = $this->getFromArrayAssembler();
        $configuration = $this->getMockOfConfiguration();

        $assembler->setConfiguration($configuration)
            ->assemble(
            array(
                'class_name'    => 'class name',
                'file_path'     => '/file/path',
                'extends'       => 'your argument is invalid'
            )
        );
    }

    public function testAssembleWithValidMandatoryData()
    {
        $assembler = $this->getFromArrayAssembler();
        $configuration = $this->getMockOfConfiguration();

        $configuration->shouldReceive('setClassName')
            ->with('my_class')
            ->andReturn($configuration)
            ->once();
        $configuration->shouldReceive('setFilePath')
            ->with('/my/file/path')
            ->once();

        $data = array(
            'class_name'    => 'my_class',
            'file_path'     => '/my/file/path'
        );

        $assembler->setConfiguration($configuration)
            ->assemble($data);
    }

    public function testAssembleWithValidAllData()
    {
$this->markTestIncomplete();
    }
} 
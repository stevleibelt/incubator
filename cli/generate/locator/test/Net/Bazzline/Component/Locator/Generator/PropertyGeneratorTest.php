<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator;

use Test\Net\Bazzline\Component\Locator\Generator\GeneratorTestCase;

/**
 * Class PropertyGeneratorTest
 * @package Test\Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
class PropertyGeneratorTest extends GeneratorTestCase
{
    /**
     * @expectedException \Net\Bazzline\Component\Locator\Generator\RuntimeException
     * @expectedExceptionMessage name is mandatory
     */
    public function testWithNoProperties()
    {
        $generator = $this->getPropertyGenerator();
        $generator->generate();
    }

    public function testWithName()
    {
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');

        $expectedString = '$unitTest;';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithNameAndValue()
    {
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');
        $generator->setValue('\'foobar\'');

        $expectedString = '$unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithStatic()
    {
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');
        $generator->setIsStatic();
        $generator->setValue('\'foobar\'');

        $expectedString = 'static $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithPrivate()
    {
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');
        $generator->setIsPrivate();
        $generator->setValue('\'foobar\'');

        $expectedString = 'private $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithProtected()
    {
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');
        $generator->setIsProtected();
        $generator->setValue('\'foobar\'');

        $expectedString = 'protected $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithTypeHint()
    {
        $this->markTestIncomplete('imlement it end extend "with all"');
    }

    public function testWithPublic()
    {
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');
        $generator->setIsPublic();
        $generator->setValue('\'foobar\'');

        $expectedString = 'public $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithDocumentation()
    {
        $documentation = $this->getDocumentationGenerator();
        $documentation->setVariable('unitTest', array('string'));
        $generator = $this->getPropertyGenerator();
        $generator->setDocumentation($documentation);
        $generator->setName('unitTest');
        $generator->setIsPublic();
        $generator->setValue('\'foobar\'');

        $expectedString =
            '/**' . PHP_EOL .
            ' * @var string $unitTest' . PHP_EOL .
            ' */' . PHP_EOL .
            'public $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $generator->generate());
        $this->assertSame($documentation, $generator->getDocumentation());
    }

    public function testWithAll()
    {
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');
        $generator->setIsPublic();
        $generator->setIsStatic();
        $generator->setValue('\'foobar\'');

        $expectedString = 'public static $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $generator->generate());
    }
} 
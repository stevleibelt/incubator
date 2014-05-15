<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator;

/**
 * Class PropertyGeneratorTest
 * @package Test\Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 * @todo markAsPrivate test etc.
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
        $this->markTestSkipped();
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');

        $expectedString = '$unitTest;';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithNameAndValue()
    {
        $this->markTestSkipped();
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');
        $generator->setValue('\'foobar\'');

        $expectedString = '$unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithStatic()
    {
        $this->markTestSkipped();
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');
        $generator->markAsStatic();
        $generator->setValue('\'foobar\'');

        $expectedString = 'static $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithPrivate()
    {
        $this->markTestSkipped();
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');
        $generator->markAsPrivate();
        $generator->setValue('\'foobar\'');

        $expectedString = 'private $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithProtected()
    {
        $this->markTestSkipped();
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');
        $generator->markAsProtected();
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
        $this->markTestSkipped();
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');
        $generator->markAsPublic();
        $generator->setValue('\'foobar\'');

        $expectedString = 'public $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithDocumentation()
    {
        $this->markTestSkipped();
        $documentation = $this->getDocumentationGenerator();
        $documentation->setVariable('unitTest', array('string'));
        $generator = $this->getPropertyGenerator();
        $generator->setDocumentation($documentation);
        $generator->setName('unitTest');
        $generator->markAsPublic();
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
        $this->markTestSkipped();
        $generator = $this->getPropertyGenerator();
        $generator->setName('unitTest');
        $generator->markAsPublic();
        $generator->markAsStatic();
        $generator->setValue('\'foobar\'');

        $expectedString = 'public static $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $generator->generate());
    }
} 
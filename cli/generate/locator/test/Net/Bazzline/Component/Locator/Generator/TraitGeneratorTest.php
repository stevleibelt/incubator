<?php
/**
 * @author sleibelt
 * @since 2014-04-28
 */

namespace Test\Net\Bazzline\Component\Locator\Generator;

/**
 * Class TraitGeneratorTest
 * @package Test\Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
class TraitGeneratorTest extends GeneratorTestCase
{
    /**
     * @expectedException \Net\Bazzline\Component\Locator\Generator\RuntimeException
     * @expectedExceptionMessage name is mandatory
     */
    public function testWithNoProperties()
    {
        $generator = $this->getTraitGenerator();
        $generator->generate();
    }

    public function testWithName()
    {
        $generator = $this->getTraitGenerator();
        $generator->setName('UnitTest');

        $expectedString =
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals('UnitTest', $generator->getName());
        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithConstants()
    {
        $generator      = $this->getTraitGenerator();
        $constantBar    = $this->getConstantGenerator();
        $constantFoo    = $this->getConstantGenerator();

        $constantBar->setName('BAR');
        $constantBar->setValue('\'foo\'');
        $constantFoo->setName('FOO');
        $constantFoo->setValue('\'bar\'');

        $generator->addConstant($constantBar);
        $generator->addConstant($constantFoo);
        $generator->setName('UnitTest');

        $indention = $generator->getIndention();
        $indention->increaseLevel();
        $expectedString =
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $indention . "const BAR = 'foo';" . PHP_EOL .
            '' . PHP_EOL .
            $indention . "const FOO = 'bar';" . PHP_EOL .
            '}';
        $indention->decreaseLevel();

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithProperties()
    {
        $generator      = $this->getTraitGenerator();
        $propertyBar    = $this->getPropertyGenerator();
        $propertyFoo    = $this->getPropertyGenerator();

        $propertyBar->setName('bar');
        $propertyBar->setValue(23);
        $propertyBar->markAsPrivate();
        $propertyFoo->setName('foo');
        $propertyFoo->setValue(42);
        $propertyFoo->markAsProtected();

        $generator->addProperty($propertyBar);
        $generator->addProperty($propertyFoo);
        $generator->setName('UnitTest');

        $indention = $generator->getIndention();
        $indention->increaseLevel();
        $expectedString =
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $indention . 'private $bar = 23;' . PHP_EOL .
            '' . PHP_EOL .
            $indention . 'protected $foo = 42;' . PHP_EOL .
            '}';
        $indention->decreaseLevel();

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithMethods()
    {
        $generator      = $this->getTraitGenerator();
        $methodOne      = $this->getMethodGenerator();
        $methodTwo      = $this->getMethodGenerator();

        $methodOne->setName('methodOne');
        $methodOne->markAsPrivate();
        $methodTwo->setName('methodTwo');
        $methodTwo->markAsProtected();

        $generator->addMethod($methodOne);
        $generator->addMethod($methodTwo);
        $generator->setName('UnitTest');

        $indention = $generator->getIndention();
        $indention->increaseLevel();
        $expectedString =
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $indention . 'private function methodOne()' . PHP_EOL .
            $indention . '{' . PHP_EOL .
            $indention . $indention . '//@todo implement' . PHP_EOL .
            $indention . '}' . PHP_EOL .
            '' . PHP_EOL .
            $indention . 'protected function methodTwo()' . PHP_EOL .
            $indention . '{' . PHP_EOL .
            $indention . $indention . '//@todo implement' . PHP_EOL .
            $indention . '}' . PHP_EOL .
            '}';
        $indention->decreaseLevel();

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithEmptyPhpDocumentation()
    {
        $documentation  = $this->getDocumentationGenerator();
        $generator      = $this->getTraitGenerator();

        $generator->setDocumentation($documentation);
        $generator->setName('UnitTest');

        $expectedString =
            '/**' . PHP_EOL .
            ' * Class UnitTest' . PHP_EOL .
            ' */' . PHP_EOL .
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
        $this->assertSame($documentation, $generator->getDocumentation());
    }

    public function testWithManualPhpDocumentation()
    {
        $documentation  = $this->getDocumentationGenerator();
        $generator      = $this->getTraitGenerator();

        $documentation->setClass('UnitTest');
        $documentation->setPackage('Foo\Bar');

        $generator->setDocumentation($documentation, false);
        $generator->setName('UnitTest');

        $expectedString =
            '/**' . PHP_EOL .
            ' * Class UnitTest' . PHP_EOL .
            ' * @package Foo\Bar' . PHP_EOL .
            ' */' . PHP_EOL .
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
        $this->assertSame($documentation, $generator->getDocumentation());
    }

    public function testWithAll()
    {
        $constantBar    = $this->getConstantGenerator();
        $constantFoo    = $this->getConstantGenerator();
        $documentation  = $this->getDocumentationGenerator();
        $methodOne      = $this->getMethodGenerator();
        $methodTwo      = $this->getMethodGenerator();
        $propertyBar    = $this->getPropertyGenerator();
        $propertyFoo    = $this->getPropertyGenerator();
        $generator      = $this->getTraitGenerator();

        $constantBar->setName('BAR');
        $constantBar->setValue('\'foo\'');
        $constantFoo->setName('FOO');
        $constantFoo->setValue('\'bar\'');
        $documentation->setClass('UnitTest');
        $documentation->setPackage('Foo\Bar');
        $methodOne->setName('methodOne');
        $methodOne->markAsPrivate();
        $methodTwo->setName('methodTwo');
        $methodTwo->markAsProtected();
        $propertyBar->setName('bar');
        $propertyBar->setValue(23);
        $propertyBar->markAsPrivate();
        $propertyFoo->setName('foo');
        $propertyFoo->setValue(42);
        $propertyFoo->markAsProtected();

        $generator->addConstant($constantBar);
        $generator->addConstant($constantFoo);
        $generator->addMethod($methodOne);
        $generator->addMethod($methodTwo);
        $generator->addProperty($propertyBar);
        $generator->addProperty($propertyFoo);
        $generator->setDocumentation($documentation);
        $generator->setName('UnitTest');

        $indention = $generator->getIndention();
        $indention->increaseLevel();
        $expectedString =
            '/**' . PHP_EOL .
            ' * Class UnitTest' . PHP_EOL .
            ' * @package Foo\Bar' . PHP_EOL .
            ' */' . PHP_EOL .
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $indention . "const BAR = 'foo';" . PHP_EOL .
            '' . PHP_EOL .
            $indention . "const FOO = 'bar';" . PHP_EOL .
            '' . PHP_EOL .
            $indention . 'private $bar = 23;' . PHP_EOL .
            '' . PHP_EOL .
            $indention . 'protected $foo = 42;' . PHP_EOL .
            '' . PHP_EOL .
            $indention . 'private function methodOne()' . PHP_EOL .
            $indention . '{' . PHP_EOL .
            $indention . $indention . '//@todo implement' . PHP_EOL .
            $indention . '}' . PHP_EOL .
            '' . PHP_EOL .
            $indention . 'protected function methodTwo()' . PHP_EOL .
            $indention . '{' . PHP_EOL .
            $indention . $indention . '//@todo implement' . PHP_EOL .
            $indention . '}' . PHP_EOL .
            '}';
        $indention->decreaseLevel();

        $this->assertEquals($expectedString, $generator->generate());
    }
} 
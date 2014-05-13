<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator;

/**
 * Class ClassGeneratorTest
 * @package Test\Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
class ClassGeneratorTest extends GeneratorTestCase
{
    /**
     * @expectedException \Net\Bazzline\Component\Locator\Generator\RuntimeException
     * @expectedExceptionMessage name is mandatory
     */
    public function testWithNoProperties()
    {
        $this->markTestSkipped();
        $generator = $this->getClassGenerator();
        $generator->generate();
    }

    public function testAsAbstract()
    {
        $generator = $this->getClassGenerator();
        $generator->setIsAbstract();
        $generator->setName('UnitTest');

        $expectedString =
            'abstract class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testAsInterface()
    {
        $generator = $this->getClassGenerator();
        $generator->setIsInterface();
        $generator->setName('UnitTest');

        $expectedString =
            'interface class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testAsFinal()
    {
        $generator = $this->getClassGenerator();
        $generator->setIsFinal();
        $generator->setName('UnitTest');

        $expectedString =
            'final class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithExtends()
    {
        $generator = $this->getClassGenerator();
        $generator->addExtends('\Bar\Foo');
        $generator->addExtends('\Foo\Bar');
        $generator->setName('UnitTest');

        $expectedString =
            'class UnitTest extends \Bar\Foo,\Foo\Bar' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithImplements()
    {
        $generator = $this->getClassGenerator();
        $generator->addImplements('\Bar\Foo');
        $generator->addImplements('\Foo\Bar');
        $generator->setName('UnitTest');

        $expectedString =
            'class UnitTest implements \Bar\Foo,\Foo\Bar' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithUse()
    {
        $generator = $this->getClassGenerator();
        $generator->addUse('Bar\Foo', 'BarFoo');
        $generator->addUse('Foo\Bar', 'FooBar');
        $generator->setName('UnitTest');

        $expectedString =
            'use Bar\Foo as BarFoo;' . PHP_EOL .
            'use Foo\Bar as FooBar;' . PHP_EOL .
            '' . PHP_EOL .
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithClassConstants()
    {
        $generator      = $this->getClassGenerator();
        $constantBar    = $this->getConstantGenerator();
        $constantFoo    = $this->getConstantGenerator();

        $constantBar->setName('BAR');
        $constantBar->setValue('\'foo\'');
        $constantFoo->setName('FOO');
        $constantFoo->setValue('\'bar\'');

        $generator->addClassConstant($constantBar);
        $generator->addClassConstant($constantFoo);
        $generator->setName('UnitTest');

        $indention = $generator->getIndention();
        $indention->increaseLevel();

        $expectedString =
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $indention . "const BAR = 'foo';" . PHP_EOL .
            '' . PHP_EOL .
            $indention . "const FOO = 'bar';" . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $indention->decreaseLevel();

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithClassProperties()
    {
        $generator       = $this->getClassGenerator();
        $propertyBar    = $this->getPropertyGenerator();
        $propertyFoo    = $this->getPropertyGenerator();

        $propertyBar->setName('bar');
        $propertyBar->setValue(23);
        $propertyBar->setIsPrivate();
        $propertyFoo->setName('foo');
        $propertyFoo->setValue(42);
        $propertyFoo->setIsProtected();

        $generator->addClassProperty($propertyBar);
        $generator->addClassProperty($propertyFoo);
        $generator->setName('UnitTest');

        $indention = $generator->getIndention();
        $indention->increaseLevel();

        $expectedString =
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $indention . 'private $bar = 23;' . PHP_EOL .
            '' . PHP_EOL .
            $indention . 'protected $foo = 42;' . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $indention->decreaseLevel();

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithMethods()
    {
        $generator   = $this->getClassGenerator();
        $methodOne  = $this->getMethodGenerator();
        $methodTwo  = $this->getMethodGenerator();

        $methodOne->setName('methodOne');
        $methodOne->setIsPrivate();
        $methodTwo->setName('methodTwo');
        $methodTwo->setIsProtected();

        $generator->addMethod($methodOne);
        $generator->addMethod($methodTwo);
        $generator->setName('UnitTest');

        $indention = $generator->getIndention();
        $indention->increaseLevel();

        $expectedString =
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $indention . 'private function methodOne()' . PHP_EOL .
            $indention . '{' . PHP_EOL .
            $indention . $generator->getIndention() . '//@todo implement' . PHP_EOL .
            $indention . '}' . PHP_EOL .
            '' . PHP_EOL .
            $indention . 'protected function methodTwo()' . PHP_EOL .
            $indention . '{' . PHP_EOL .
            $indention . $generator->getIndention() . '//@todo implement' . PHP_EOL .
            $indention . '}' . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $indention->decreaseLevel();

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithTraits()
    {
        $generator   = $this->getClassGenerator();
        $traitOne   = $this->getTraitGenerator();
        $traitTwo   = $this->getTraitGenerator();

        $traitOne->setName('TraitOne');
        $traitTwo->setName('TraitTwo');

        $generator->addTrait($traitOne);
        $generator->addTrait($traitTwo);
        $generator->setName('UnitTest');

        $indention = $generator->getIndention();
        $indention->increaseLevel();

        $expectedString =
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $indention . 'use TraitOne,TraitTwo;' . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $indention->decreaseLevel();

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithPhpDocumentation()
    {
        $documentation  = $this->getDocumentationGenerator();
        $generator       = $this->getClassGenerator();

        $documentation->setClass('UnitTest');
        $documentation->setPackage('Foo\Bar');

        $generator->setDocumentation($documentation);
        $generator->setNamespace('Foo\Bar');
        $generator->setName('UnitTest');

        $expectedString =
            'namespace Foo\Bar;' . PHP_EOL .
            '' . PHP_EOL .
            '/**' . PHP_EOL .
            ' * Class UnitTest' . PHP_EOL .
            ' * @package Foo\Bar' . PHP_EOL .
            ' */' . PHP_EOL .
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
        $this->assertSame($documentation, $generator->getDocumentation());
    }

    public function testWithNamespace()
    {
        $generator = $this->getClassGenerator();

        $generator->setNamespace('Foo\Bar');
        $generator->setName('UnitTest');

        $expectedString =
            'namespace Foo\Bar;' . PHP_EOL .
            '' . PHP_EOL .
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithALot()
    {
        $documentation  = $this->getDocumentationGenerator();
        $constantBar    = $this->getConstantGenerator();
        $constantFoo    = $this->getConstantGenerator();
        $methodOne      = $this->getMethodGenerator();
        $methodTwo      = $this->getMethodGenerator();
        $propertyBar    = $this->getPropertyGenerator();
        $propertyFoo    = $this->getPropertyGenerator();
        $generator      = $this->getClassGenerator();

        $constantBar->setName('BAR');
        $constantBar->setValue('\'foo\'');
        $constantFoo->setName('FOO');
        $constantFoo->setValue('\'bar\'');

        $documentation->setClass('UnitTest');
        $documentation->setPackage('Foo\Bar');
        $methodOne->setName('methodOne');
        $methodOne->setIsPrivate();
        $methodTwo->setName('methodTwo');
        $methodTwo->setIsProtected();
        $propertyBar->setName('bar');
        $propertyBar->setValue(23);
        $propertyBar->setIsPrivate();
        $propertyFoo->setName('foo');
        $propertyFoo->setValue(42);
        $propertyFoo->setIsProtected();

        $generator->addClassConstant($constantBar);
        $generator->addClassConstant($constantFoo);
        $generator->addClassProperty($propertyBar);
        $generator->addClassProperty($propertyFoo);
        $generator->addExtends('BarFoo');
        $generator->addExtends('FooBar');
        $generator->addImplements('BarFooInterface');
        $generator->addImplements('FooBarInterface');
        $generator->addMethod($methodOne);
        $generator->addMethod($methodTwo);
        $generator->addUse('Bar\Foo', 'BarFoo');
        $generator->addUse('BarFoo\BarFooInterface');
        $generator->addUse('Foo\Bar', 'FooBar');
        $generator->addUse('FooBar\FooBarInterface');
        $generator->setDocumentation($documentation);
        $generator->setName('UnitTest');
        $generator->setNamespace('Baz');

        $indention = $generator->getIndention();
        $indention->increaseLevel();

        $expectedString =
            'namespace Baz;' . PHP_EOL .
            '' . PHP_EOL .
            'use Bar\Foo as BarFoo;' . PHP_EOL .
            'use BarFoo\BarFooInterface;' . PHP_EOL .
            'use Foo\Bar as FooBar;' . PHP_EOL .
            'use FooBar\FooBarInterface;' . PHP_EOL .
            '' . PHP_EOL .
            '/**' . PHP_EOL .
            ' * Class UnitTest' . PHP_EOL .
            ' * @package Foo\Bar' . PHP_EOL .
            ' */' . PHP_EOL .
            'class UnitTest extends BarFoo,FooBar implements BarFooInterface,FooBarInterface' . PHP_EOL .
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
            '' . PHP_EOL .
            '}';

        $indention->decreaseLevel();

        $this->assertEquals($expectedString, $generator->generate());
    }
}

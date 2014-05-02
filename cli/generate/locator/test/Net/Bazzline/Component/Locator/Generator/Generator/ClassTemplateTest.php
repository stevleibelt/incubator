<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Template;

use Test\Net\Bazzline\Component\Locator\Generator\GeneratorTestCase;

/**
 * Class ClassTemplateTest
 * @package Test\Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
class ClassTemplateTest extends GeneratorTestCase
{
    /**
     * @expectedException \Net\Bazzline\Component\Locator\Generator\RuntimeException
     * @expectedExceptionMessage name is mandatory
     */
    public function testWithNoProperties()
    {
        $template = $this->getClassTemplate();
        $template->fillOut();
    }

    public function testAsAbstract()
    {
        $template = $this->getClassTemplate();
        $template->setIsAbstract();
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'abstract class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testAsInterface()
    {
        $template = $this->getClassTemplate();
        $template->setIsInterface();
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'interface class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testAsFinal()
    {
        $template = $this->getClassTemplate();
        $template->setIsFinal();
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'final class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithExtends()
    {
        $template = $this->getClassTemplate();
        $template->addExtends('\Bar\Foo');
        $template->addExtends('\Foo\Bar');
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'class UnitTest extends \Bar\Foo,\Foo\Bar' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithImplements()
    {
        $template = $this->getClassTemplate();
        $template->addImplements('\Bar\Foo');
        $template->addImplements('\Foo\Bar');
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'class UnitTest implements \Bar\Foo,\Foo\Bar' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithUse()
    {
        $template = $this->getClassTemplate();
        $template->addUse('Bar\Foo', 'BarFoo');
        $template->addUse('Foo\Bar', 'FooBar');
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'use Bar\Foo as BarFoo;' . PHP_EOL .
            'use Foo\Bar as FooBar;' . PHP_EOL .
            '' . PHP_EOL .
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithClassConstants()
    {
        $template       = $this->getClassTemplate();
        $constantBar    = $this->getConstantTemplate();
        $constantFoo    = $this->getConstantTemplate();

        $constantBar->setName('BAR');
        $constantBar->setValue('\'foo\'');
        $constantFoo->setName('FOO');
        $constantFoo->setValue('\'bar\'');

        $template->addClassConstant($constantBar);
        $template->addClassConstant($constantFoo);
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $template->getIndention() . "const BAR = 'foo';" . PHP_EOL .
            '' . PHP_EOL .
            $template->getIndention() . "const FOO = 'bar';" . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithClassProperties()
    {
        $template       = $this->getClassTemplate();
        $propertyBar    = $this->getPropertyTemplate();
        $propertyFoo    = $this->getPropertyTemplate();

        $propertyBar->setName('bar');
        $propertyBar->setValue(23);
        $propertyBar->setIsPrivate();
        $propertyFoo->setName('foo');
        $propertyFoo->setValue(42);
        $propertyFoo->setIsProtected();

        $template->addClassProperty($propertyBar);
        $template->addClassProperty($propertyFoo);
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $template->getIndention() . 'private $bar = 23;' . PHP_EOL .
            '' . PHP_EOL .
            $template->getIndention() . 'protected $foo = 42;' . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithMethods()
    {
        $template   = $this->getClassTemplate();
        $methodOne  = $this->getMethodTemplate();
        $methodTwo  = $this->getMethodTemplate();

        $methodOne->setName('methodOne');
        $methodOne->setIsPrivate();
        $methodTwo->setName('methodTwo');
        $methodTwo->setIsProtected();

        $template->addMethod($methodOne);
        $template->addMethod($methodTwo);
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $template->getIndention() . 'private function methodOne()' . PHP_EOL .
            $template->getIndention() . '{' . PHP_EOL .
            $template->getIndention() . $template->getIndention() . '//@todo implement' . PHP_EOL .
            $template->getIndention() . '}' . PHP_EOL .
            '' . PHP_EOL .
            $template->getIndention() . 'protected function methodTwo()' . PHP_EOL .
            $template->getIndention() . '{' . PHP_EOL .
            $template->getIndention() . $template->getIndention() . '//@todo implement' . PHP_EOL .
            $template->getIndention() . '}' . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithTraits()
    {
        $template   = $this->getClassTemplate();
        $traitOne   = $this->getTraitTemplate();
        $traitTwo   = $this->getTraitTemplate();

        $traitOne->setName('TraitOne');
        $traitTwo->setName('TraitTwo');

        $template->addTrait($traitOne);
        $template->addTrait($traitTwo);
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $template->getIndention() . 'use TraitOne,TraitTwo;' . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithPhpDocumentation()
    {
        $documentation  = $this->getPhpDocumentationTemplate();
        $template       = $this->getClassTemplate();

        $documentation->setClass('UnitTest');
        $documentation->setPackage('Foo\Bar');

        $template->setDocumentation($documentation);
        $template->setNamespace('Foo\Bar');
        $template->setName('UnitTest');
        $template->fillOut();

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

        $this->assertEquals($expectedString, $template->andConvertToString());
        $this->assertSame($documentation, $template->getDocumentation());
    }

    public function testWithNamespace()
    {
        $template = $this->getClassTemplate();

        $template->setNamespace('Foo\Bar');
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'namespace Foo\Bar;' . PHP_EOL .
            '' . PHP_EOL .
            'class UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithALot()
    {
        $documentation  = $this->getPhpDocumentationTemplate();
        $constantBar    = $this->getConstantTemplate();
        $constantFoo    = $this->getConstantTemplate();
        $methodOne      = $this->getMethodTemplate();
        $methodTwo      = $this->getMethodTemplate();
        $propertyBar    = $this->getPropertyTemplate();
        $propertyFoo    = $this->getPropertyTemplate();
        $template       = $this->getClassTemplate();

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

        $template->addClassConstant($constantBar);
        $template->addClassConstant($constantFoo);
        $template->addClassProperty($propertyBar);
        $template->addClassProperty($propertyFoo);
        $template->addExtends('BarFoo');
        $template->addExtends('FooBar');
        $template->addImplements('BarFooInterface');
        $template->addImplements('FooBarInterface');
        $template->addMethod($methodOne);
        $template->addMethod($methodTwo);
        $template->addUse('Bar\Foo', 'BarFoo');
        $template->addUse('BarFoo\BarFooInterface');
        $template->addUse('Foo\Bar', 'FooBar');
        $template->addUse('FooBar\FooBarInterface');
        $template->setDocumentation($documentation);
        $template->setName('UnitTest');
        $template->setNamespace('Baz');
        $template->fillOut();

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
            $template->getIndention() . "const BAR = 'foo';" . PHP_EOL .
            '' . PHP_EOL .
            $template->getIndention() . "const FOO = 'bar';" . PHP_EOL .
            '' . PHP_EOL .
            $template->getIndention() . 'private $bar = 23;' . PHP_EOL .
            '' . PHP_EOL .
            $template->getIndention() . 'protected $foo = 42;' . PHP_EOL .
            '' . PHP_EOL .
            $template->getIndention() . 'private function methodOne()' . PHP_EOL .
            $template->getIndention() . '{' . PHP_EOL .
            $template->getIndention() . $template->getIndention() . '//@todo implement' . PHP_EOL .
            $template->getIndention() . '}' . PHP_EOL .
            '' . PHP_EOL .
            $template->getIndention() . 'protected function methodTwo()' . PHP_EOL .
            $template->getIndention() . '{' . PHP_EOL .
            $template->getIndention() . $template->getIndention() . '//@todo implement' . PHP_EOL .
            $template->getIndention() . '}' . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }
}

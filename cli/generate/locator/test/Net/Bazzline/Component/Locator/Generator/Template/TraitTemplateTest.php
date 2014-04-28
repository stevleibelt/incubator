<?php
/**
 * @author sleibelt
 * @since 2014-04-28
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Template;

use Test\Net\Bazzline\Component\Locator\Generator\GeneratorTestCase;

/**
 * Class TraitTemplateTest
 * @package Test\Net\Bazzline\Component\Locator\Generator\Template
 */
class TraitTemplateTest extends GeneratorTestCase
{
    /**
     * @expectedException \Net\Bazzline\Component\Locator\Generator\RuntimeException
     * @expectedExceptionMessage name is mandatory
     */
    public function testWithNoProperties()
    {
        $template = $this->getTraitTemplate();
        $template->fillOut();
    }

    public function testWithName()
    {
        $template = $this->getTraitTemplate();
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithConstants()
    {
        $template       = $this->getTraitTemplate();
        $constantBar    = $this->getConstantTemplate();
        $constantFoo    = $this->getConstantTemplate();

        $constantBar->setName('BAR');
        $constantBar->setValue('\'foo\'');
        $constantFoo->setName('FOO');
        $constantFoo->setValue('\'bar\'');

        $template->addTraitConstant($constantBar);
        $template->addTraitConstant($constantFoo);
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $template->getIndention() . "const BAR = 'foo';" . PHP_EOL .
            '' . PHP_EOL .
            $template->getIndention() . "const FOO = 'bar';" . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithProperties()
    {
        $template       = $this->getTraitTemplate();
        $propertyBar    = $this->getPropertyTemplate();
        $propertyFoo    = $this->getPropertyTemplate();

        $propertyBar->setName('bar');
        $propertyBar->setValue(23);
        $propertyBar->setIsPrivate();
        $propertyFoo->setName('foo');
        $propertyFoo->setValue(42);
        $propertyFoo->setIsProtected();

        $template->addTraitProperty($propertyBar);
        $template->addTraitProperty($propertyFoo);
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'trait UnitTest' . PHP_EOL .
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
        $template       = $this->getTraitTemplate();
        $methodOne      = $this->getMethodTemplate();
        $methodTwo      = $this->getMethodTemplate();

        $methodOne->setName('methodOne');
        $methodOne->setIsPrivate();
        $methodTwo->setName('methodTwo');
        $methodTwo->setIsProtected();

        $template->addMethod($methodOne);
        $template->addMethod($methodTwo);
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            'trait UnitTest' . PHP_EOL .
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

    public function testWithPhpDocumentation()
    {
        $documentation  = $this->getPhpDocumentationTemplate();
        $template       = $this->getTraitTemplate();

        $documentation->setClass('UnitTest');
        $documentation->setPackage('Foo\Bar');

        $template->setDocumentation($documentation);
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' * Class UnitTest' . PHP_EOL .
            ' * @package Foo\Bar' . PHP_EOL .
            ' */' . PHP_EOL .
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithAll()
    {
        $constantBar    = $this->getConstantTemplate();
        $constantFoo    = $this->getConstantTemplate();
        $documentation  = $this->getPhpDocumentationTemplate();
        $methodOne      = $this->getMethodTemplate();
        $methodTwo      = $this->getMethodTemplate();
        $propertyBar    = $this->getPropertyTemplate();
        $propertyFoo    = $this->getPropertyTemplate();
        $template       = $this->getTraitTemplate();

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

        $template->addTraitConstant($constantBar);
        $template->addTraitConstant($constantFoo);
        $template->addMethod($methodOne);
        $template->addMethod($methodTwo);
        $template->addTraitProperty($propertyBar);
        $template->addTraitProperty($propertyFoo);
        $template->setDocumentation($documentation);
        $template->setName('UnitTest');
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' * Class UnitTest' . PHP_EOL .
            ' * @package Foo\Bar' . PHP_EOL .
            ' */' . PHP_EOL .
            'trait UnitTest' . PHP_EOL .
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
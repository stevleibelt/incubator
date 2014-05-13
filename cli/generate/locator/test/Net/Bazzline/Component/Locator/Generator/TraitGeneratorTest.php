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
        $this->markTestSkipped();
        $generator = $this->getTraitGenerator();
        $generator->generate();
    }

    public function testWithName()
    {
        $this->markTestSkipped();
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
        $this->markTestSkipped();
        $generator       = $this->getTraitGenerator();
        $constantBar    = $this->getConstantGenerator();
        $constantFoo    = $this->getConstantGenerator();

        $constantBar->setName('BAR');
        $constantBar->setValue('\'foo\'');
        $constantFoo->setName('FOO');
        $constantFoo->setValue('\'bar\'');

        $generator->addTraitConstant($constantBar);
        $generator->addTraitConstant($constantFoo);
        $generator->setName('UnitTest');

        $expectedString =
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . "const BAR = 'foo';" . PHP_EOL .
            '' . PHP_EOL .
            $generator->getIndention() . "const FOO = 'bar';" . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithProperties()
    {
        $this->markTestSkipped();
        $generator       = $this->getTraitGenerator();
        $propertyBar    = $this->getPropertyGenerator();
        $propertyFoo    = $this->getPropertyGenerator();

        $propertyBar->setName('bar');
        $propertyBar->setValue(23);
        $propertyBar->setIsPrivate();
        $propertyFoo->setName('foo');
        $propertyFoo->setValue(42);
        $propertyFoo->setIsProtected();

        $generator->addTraitProperty($propertyBar);
        $generator->addTraitProperty($propertyFoo);
        $generator->setName('UnitTest');

        $expectedString =
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . 'private $bar = 23;' . PHP_EOL .
            '' . PHP_EOL .
            $generator->getIndention() . 'protected $foo = 42;' . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithMethods()
    {
        $this->markTestSkipped();
        $generator      = $this->getTraitGenerator();
        $methodOne      = $this->getMethodGenerator();
        $methodTwo      = $this->getMethodGenerator();

        $methodOne->setName('methodOne');
        $methodOne->setIsPrivate();
        $methodTwo->setName('methodTwo');
        $methodTwo->setIsProtected();

        $generator->addMethod($methodOne);
        $generator->addMethod($methodTwo);
        $generator->setName('UnitTest');

        $expectedString =
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . 'private function methodOne()' . PHP_EOL .
            $generator->getIndention() . '{' . PHP_EOL .
            $generator->getIndention() . $generator->getIndention() . '//@todo implement' . PHP_EOL .
            $generator->getIndention() . '}' . PHP_EOL .
            '' . PHP_EOL .
            $generator->getIndention() . 'protected function methodTwo()' . PHP_EOL .
            $generator->getIndention() . '{' . PHP_EOL .
            $generator->getIndention() . $generator->getIndention() . '//@todo implement' . PHP_EOL .
            $generator->getIndention() . '}' . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithEmptyPhpDocumentation()
    {
        $this->markTestSkipped();
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
        $this->markTestSkipped();
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
        $this->markTestSkipped();
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
        $methodOne->setIsPrivate();
        $methodTwo->setName('methodTwo');
        $methodTwo->setIsProtected();
        $propertyBar->setName('bar');
        $propertyBar->setValue(23);
        $propertyBar->setIsPrivate();
        $propertyFoo->setName('foo');
        $propertyFoo->setValue(42);
        $propertyFoo->setIsProtected();

        $generator->addTraitConstant($constantBar);
        $generator->addTraitConstant($constantFoo);
        $generator->addMethod($methodOne);
        $generator->addMethod($methodTwo);
        $generator->addTraitProperty($propertyBar);
        $generator->addTraitProperty($propertyFoo);
        $generator->setDocumentation($documentation);
        $generator->setName('UnitTest');

        $expectedString =
            '/**' . PHP_EOL .
            ' * Class UnitTest' . PHP_EOL .
            ' * @package Foo\Bar' . PHP_EOL .
            ' */' . PHP_EOL .
            'trait UnitTest' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . "const BAR = 'foo';" . PHP_EOL .
            '' . PHP_EOL .
            $generator->getIndention() . "const FOO = 'bar';" . PHP_EOL .
            '' . PHP_EOL .
            $generator->getIndention() . 'private $bar = 23;' . PHP_EOL .
            '' . PHP_EOL .
            $generator->getIndention() . 'protected $foo = 42;' . PHP_EOL .
            '' . PHP_EOL .
            $generator->getIndention() . 'private function methodOne()' . PHP_EOL .
            $generator->getIndention() . '{' . PHP_EOL .
            $generator->getIndention() . $generator->getIndention() . '//@todo implement' . PHP_EOL .
            $generator->getIndention() . '}' . PHP_EOL .
            '' . PHP_EOL .
            $generator->getIndention() . 'protected function methodTwo()' . PHP_EOL .
            $generator->getIndention() . '{' . PHP_EOL .
            $generator->getIndention() . $generator->getIndention() . '//@todo implement' . PHP_EOL .
            $generator->getIndention() . '}' . PHP_EOL .
            '' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }
} 
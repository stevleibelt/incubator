<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-14 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator;

/**
 * Class FileGeneratorTest
 * @package Test\Net\Bazzline\Component\Locator\Generator
 */
class FileGeneratorTest extends GeneratorTestCase
{
    public function testWithNoProperties()
    {
        $generator = $this->getFileGenerator();
        $this->assertEquals('', $generator->generate());
    }

    public function testWithConstants()
    {
        $constantBar = $this->getConstantGenerator();
        $constantFoo = $this->getConstantGenerator();
        $generator = $this->getFileGenerator();
        $indention = $generator->getIndention();

        $constantBar->setName('BAR');
        $constantBar->setValue('\'foo\'');
        $constantFoo->setName('FOO');
        $constantFoo->setValue('\'bar\'');

        $generator->addFileConstant($constantBar);
        $generator->addFileConstant($constantFoo);

        $expectedContent = '<?php' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'const BAR = \'foo\';' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'const FOO = \'bar\';';

        $this->assertEquals($expectedContent, $generator->generate());
    }

    public function testWithProperties()
    {
        $generator = $this->getFileGenerator();
        $indention = $generator->getIndention();
        $propertyBar = $this->getPropertyGenerator();
        $propertyFoo = $this->getPropertyGenerator();

        $propertyBar->setName('bar');
        $propertyBar->markAsPublic();
        $propertyBar->setValue('\'foo\'');
        $propertyFoo->setName('foo');
        $propertyFoo->setValue('\'bar\'');
        $propertyFoo->markAsPrivate();

        $generator->addFileProperty($propertyBar);
        $generator->addFileProperty($propertyFoo);

        $expectedContent = '<?php' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'public $bar = \'foo\';' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'private $foo = \'bar\';';

        $this->assertEquals($expectedContent, $generator->generate());
    }

    public function testWithClasses()
    {
        $classBar = $this->getClassGenerator();
        $classFoo = $this->getClassGenerator();
        $generator = $this->getFileGenerator();
        $indention = $generator->getIndention();

        $classBar->setName('bar');
        $classFoo->setName('foo');

        $generator->addClass($classBar);
        $generator->addClass($classFoo);

        $expectedContent = '<?php' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'class bar' . PHP_EOL .
            $indention . '{' . PHP_EOL .
            $indention . '}' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'class foo' . PHP_EOL .
            $indention . '{' . PHP_EOL .
            $indention . '}';

        $this->assertEquals($expectedContent, $generator->generate());
    }

    public function testWithMethods()
    {
        $methodBar = $this->getMethodGenerator();
        $methodFoo = $this->getMethodGenerator();
        $generator = $this->getFileGenerator();
        $indention = $generator->getIndention();

        $methodBar->setName('bar');
        $methodBar->markAsPublic();
        $methodFoo->setName('foo');
        $methodFoo->markAsProtected();

        $generator->addMethod($methodBar);
        $generator->addMethod($methodFoo);

        $indention->increaseLevel();
        $doubledIndention = $indention->toString();
        $indention->decreaseLevel();

        $expectedContent = '<?php' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'public function bar()' . PHP_EOL .
            $indention . '{' . PHP_EOL .
            $doubledIndention . '//@todo implement' . PHP_EOL .
            $indention . '}' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'protected function foo()' . PHP_EOL .
            $indention . '{' . PHP_EOL .
            $doubledIndention . '//@todo implement' . PHP_EOL .
            $indention . '}';

        $this->assertEquals($expectedContent, $generator->generate());
    }

    public function testWithContent()
    {
        $this->markTestIncomplete();
    }

    public function testWithAll()
    {
        $classBar = $this->getClassGenerator();
        $classFoo = $this->getClassGenerator();
        $constantBar = $this->getConstantGenerator();
        $constantFoo = $this->getConstantGenerator();
        $generator = $this->getFileGenerator();
        $indention = $generator->getIndention();
        $propertyBar = $this->getPropertyGenerator();
        $propertyFoo = $this->getPropertyGenerator();

        $classBar->setName('bar');
        $classFoo->setName('foo');
        $constantBar->setName('BAR');
        $constantBar->setValue('\'foo\'');
        $constantFoo->setName('FOO');
        $constantFoo->setValue('\'bar\'');
        $propertyBar->setName('bar');
        $propertyBar->markAsPublic();
        $propertyBar->setValue('\'foo\'');
        $propertyFoo->setName('foo');
        $propertyFoo->setValue('\'bar\'');
        $propertyFoo->markAsPrivate();

        $generator->addClass($classBar);
        $generator->addClass($classFoo);
        $generator->addFileConstant($constantBar);
        $generator->addFileConstant($constantFoo);
        $generator->addFileProperty($propertyBar);
        $generator->addFileProperty($propertyFoo);
        $generator->markAsExecutable();

        $expectedContent = '#!/bin/php' . PHP_EOL .
            $indention . '<?php' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'const BAR = \'foo\';' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'const FOO = \'bar\';' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'public $bar = \'foo\';' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'private $foo = \'bar\';' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'class bar' . PHP_EOL .
            $indention . '{' . PHP_EOL .
            $indention . '}' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'class foo' . PHP_EOL .
            $indention . '{' . PHP_EOL .
            $indention . '}';

        $this->assertEquals($expectedContent, $generator->generate());
    }
}
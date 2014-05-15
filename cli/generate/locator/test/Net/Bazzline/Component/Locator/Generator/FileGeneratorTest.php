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

    public function testWithAll()
    {
        $constantBar = $this->getConstantGenerator();
        $constantFoo = $this->getConstantGenerator();
        $generator = $this->getFileGenerator();
        $indention = $generator->getIndention();
        $propertyBar = $this->getPropertyGenerator();
        $propertyFoo = $this->getPropertyGenerator();

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

        $generator->addFileConstant($constantBar);
        $generator->addFileConstant($constantFoo);
        $generator->addFileProperty($propertyBar);
        $generator->addFileProperty($propertyFoo);

        $expectedContent = '<?php' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'const BAR = \'foo\';' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'const FOO = \'bar\';' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'public $bar = \'foo\';' . PHP_EOL .
            $indention . PHP_EOL .
            $indention . 'private $foo = \'bar\';';

        $this->assertEquals($expectedContent, $generator->generate());
    }
}
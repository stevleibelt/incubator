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

    public function testWithAll()
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
}
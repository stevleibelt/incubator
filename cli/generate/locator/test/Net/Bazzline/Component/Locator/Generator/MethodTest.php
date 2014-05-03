<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Test\Net\Bazzline\Component\Locator\Generator;

use Test\Net\Bazzline\Component\Locator\Generator\GeneratorTestCase;

/**
 * Class MethodGeneratorTest
 * @package Test\Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
class MethodGeneratorTest extends GeneratorTestCase
{
    public function testWithNoProperties()
    {
        $generator = $this->getMethodGenerator();
        $generator->setName('unittest');

        $expectedString =
            'function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testAsAbstract()
    {
        $generator = $this->getMethodGenerator();
        $generator->setIsAbstract();
        $generator->setName('unittest');

        $expectedString = 'abstract function unittest();';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithNoBody()
    {
        $generator = $this->getMethodGenerator();
        $generator->setHasNoBody();
        $generator->setName('unittest');

        $expectedString = 'function unittest();';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithBody()
    {
        $body = array(
            '$bar = new Bar();',
            '$foo = new Foo();',
            '$foobar->add($bar);',
            '$foobar->add($foo);',
            '',
            'return $foobar'
        );

        $generator = $this->getMethodGenerator();
        $generator->setName('unittest');
        $generator->setBody($body);

        $expectedString =
            'function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '$bar = new Bar();' . PHP_EOL .
            $generator->getIndention() . '$foo = new Foo();' . PHP_EOL .
            $generator->getIndention() . '$foobar->add($bar);' . PHP_EOL .
            $generator->getIndention() . '$foobar->add($foo);' . PHP_EOL .
            '' . PHP_EOL .
            $generator->getIndention() . 'return $foobar' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testAsFinal()
    {
        $generator = $this->getMethodGenerator();
        $generator->setIsFinal();
        $generator->setName('unittest');

        $expectedString =
            'final function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testAsPrivate()
    {
        $generator = $this->getMethodGenerator();
        $generator->setIsPrivate();
        $generator->setName('unittest');

        $expectedString =
            'private function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testAsProtected()
    {
        $generator = $this->getMethodGenerator();
        $generator->setIsProtected();
        $generator->setName('unittest');

        $expectedString =
            'protected function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testAsPublic()
    {
        $generator = $this->getMethodGenerator();
        $generator->setName('unittest');
        $generator->setIsPublic();

        $expectedString =
            'public function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithEmptyPhpDocumentation()
    {
        $documentation  = $this->getDocumentationGenerator();
        $generator       = $this->getMethodGenerator();

        $generator->setDocumentation($documentation);
        $generator->addParameter('foo', '', 'string');
        $generator->setName('unittest');
        $generator->setIsPublic();

        $expectedString =
            '/**' . PHP_EOL .
            ' * @param string $foo' . PHP_EOL .
            ' */' . PHP_EOL .
            'public function unittest($foo)' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
        $this->assertSame($documentation, $generator->getDocumentation());
    }

    public function testWithManualPhpDocumentation()
    {
        $documentation  = $this->getDocumentationGenerator();
        $generator       = $this->getMethodGenerator();

        $documentation->addParameter('foo', 'string');

        $generator->setDocumentation($documentation, false);
        $generator->addParameter('foo');
        $generator->setName('unittest');
        $generator->setIsPublic();

        $expectedString =
            '/**' . PHP_EOL .
            ' * @param string $foo' . PHP_EOL .
            ' */' . PHP_EOL .
            'public function unittest($foo)' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
        $this->assertSame($documentation, $generator->getDocumentation());
    }

    public function testWithALot()
    {
        $body = array(
            '$bar = new Bar();',
            '$foo = new Foo();',
            '$foobar->add($bar);',
            '$foobar->add($foo);',
            '',
            'return $foobar'
        );

        $generator = $this->getMethodGenerator();
        $generator->setBody($body);
        $generator->setName('unittest');
        $generator->setIsFinal();
        $generator->setIsPublic();

        $expectedString =
            'final public function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '$bar = new Bar();' . PHP_EOL .
            $generator->getIndention() . '$foo = new Foo();' . PHP_EOL .
            $generator->getIndention() . '$foobar->add($bar);' . PHP_EOL .
            $generator->getIndention() . '$foobar->add($foo);' . PHP_EOL .
            '' . PHP_EOL .
            $generator->getIndention() . 'return $foobar' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }
}
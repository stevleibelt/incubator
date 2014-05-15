<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Test\Net\Bazzline\Component\Locator\Generator;

/**
 * Class MethodGeneratorTest
 * @package Test\Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
class MethodGeneratorTest extends GeneratorTestCase
{
    public function testWithNoProperties()
    {
        $this->markTestSkipped();
        $generator = $this->getMethodGenerator();
        $generator->setName('unittest');

        $expectedString =
            'function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testMarkAsAbstract()
    {
        $this->markTestSkipped();
        $generator = $this->getMethodGenerator();
        $generator->setIsAbstract();
        $generator->setName('unittest');

        $expectedString = 'abstract function unittest();';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testMarkAsHasNoBody()
    {
        $this->markTestSkipped();
        $generator = $this->getMethodGenerator();
        $generator->markAsHasNoBody();
        $generator->setName('unittest');

        $expectedString = 'function unittest();';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithBody()
    {
        $this->markTestSkipped();
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

    public function testMarkAsFinal()
    {
        $this->markTestSkipped();
        $generator = $this->getMethodGenerator();
        $generator->markAsFinal();
        $generator->setName('unittest');

        $expectedString =
            'final function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testMarkAsPrivate()
    {
        $this->markTestSkipped();
        $generator = $this->getMethodGenerator();
        $generator->markAsPrivate();
        $generator->setName('unittest');

        $expectedString =
            'private function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testMarkAsProtected()
    {
        $this->markTestSkipped();
        $generator = $this->getMethodGenerator();
        $generator->markAsProtected();
        $generator->setName('unittest');

        $expectedString =
            'protected function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testMarkAsPublic()
    {
        $this->markTestSkipped();
        $generator = $this->getMethodGenerator();
        $generator->setName('unittest');
        $generator->markAsPublic();

        $expectedString =
            'public function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testMarkAsStatic()
    {
        $this->markTestSkipped();
        $generator = $this->getMethodGenerator();
        $generator->setName('unittest');
        $generator->markAsPublic();
        $generator->markAsStatic();

        $expectedString =
            'static public function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $generator->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $generator->generate());
    }

    public function testWithEmptyPhpDocumentation()
    {
        $this->markTestSkipped();
        $documentation  = $this->getDocumentationGenerator();
        $generator       = $this->getMethodGenerator();

        $generator->setDocumentation($documentation);
        $generator->addParameter('foo', '', 'string');
        $generator->setName('unittest');
        $generator->markAsPublic();

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
        $this->markTestSkipped();
        $documentation  = $this->getDocumentationGenerator();
        $generator       = $this->getMethodGenerator();

        $documentation->addParameter('foo', 'string');

        $generator->setDocumentation($documentation, false);
        $generator->addParameter('foo');
        $generator->setName('unittest');
        $generator->markAsPublic();

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
        $this->markTestSkipped();
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
        $generator->markAsFinal();
        $generator->markAsPublic();

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
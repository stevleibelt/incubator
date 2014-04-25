<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Template;

use PHPUnit_Framework_TestCase;
use Net\Bazzline\Component\Locator\Generator\Template\MethodTemplate;

/**
 * Class MethodTemplateTest
 *
 * @package Test\Net\Bazzline\Component\Locator\Generator\Template
 */
class MethodTemplateTest extends PHPUnit_Framework_TestCase
{
    public function testWithNoProperties()
    {
        $template = $this->getTemplate();
        $template->setName('unittest');
        $template->render();

        $expectedArray = array(
            'function unittest()',
            array(
                '{',
                array (
                    '//@todo implement'
                ),
                '}'
            )
        );
        $expectedString =
            'function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testAsAbstract()
    {
        $template = $this->getTemplate();
        $template->setAbstract();
        $template->setName('unittest');
        $template->render();

        $expectedArray = array(
            'abstract function unittest()',
            array(
                ';',
            )
        );
        $expectedString =
            'abstract function unittest()' . PHP_EOL .
            ';';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
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

        $template = $this->getTemplate();
        $template->setName('unittest');
        $template->setBody($body);
        $template->render();

        $expectedArray = array(
            'function unittest()',
            array(
                '{',
                $body,
                '}'
            )
        );
        $expectedString =
            'function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            '$bar = new Bar();' . PHP_EOL .
            '$foo = new Foo();' . PHP_EOL .
            '$foobar->add($bar);' . PHP_EOL .
            '$foobar->add($foo);' . PHP_EOL .
            'return $foobar' . PHP_EOL .
            '}';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testAsFinal()
    {
        $template = $this->getTemplate();
        $template->setFinal();
        $template->setName('unittest');
        $template->render();

        $expectedArray = array(
            'final function unittest()',
            array(
                '{',
                array (
                    '//@todo implement'
                ),
                '}'
            )
        );
        $expectedString =
            'final function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testAsPrivate()
    {
        $template = $this->getTemplate();
        $template->setPrivate();
        $template->setName('unittest');
        $template->render();

        $expectedArray = array(
            'private function unittest()',
            array(
                '{',
                array (
                    '//@todo implement'
                ),
                '}'
            )
        );
        $expectedString =
            'private function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testAsProtected()
    {
        $template = $this->getTemplate();
        $template->setProtected();
        $template->setName('unittest');
        $template->render();

        $expectedArray = array(
            'protected function unittest()',
            array(
                '{',
                array (
                    '//@todo implement'
                ),
                '}'
            )
        );
        $expectedString =
            'protected function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testAsPublic()
    {
        $template = $this->getTemplate();
        $template->setName('unittest');
        $template->setPublic();
        $template->render();

        $expectedArray = array(
            'public function unittest()',
            array(
                '{',
                array (
                    '//@todo implement'
                ),
                '}'
            )
        );
        $expectedString =
            'public function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
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

        $template = $this->getTemplate();
        $template->setBody($body);
        $template->setName('unittest');
        $template->setFinal();
        $template->setPublic();
        $template->render();

        $expectedArray = array(
            'final public function unittest()',
            array(
                '{',
                $body,
                '}'
            )
        );
        $expectedString =
            'final public function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            '$bar = new Bar();' . PHP_EOL .
            '$foo = new Foo();' . PHP_EOL .
            '$foobar->add($bar);' . PHP_EOL .
            '$foobar->add($foo);' . PHP_EOL .
            'return $foobar' . PHP_EOL .
            '}';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    /**
     * @return MethodTemplate
     */
    private function getTemplate()
    {
        return new MethodTemplate();
    }
} 
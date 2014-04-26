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
 * @package Test\Net\Bazzline\Component\Locator\Generator\Template
 */
class MethodTemplateTest extends PHPUnit_Framework_TestCase
{
    public function testWithNoProperties()
    {
        $template = $this->getTemplate();
        $template->setName('unittest');
        $template->fillOut();

        $expectedString =
            'function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $template->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testAsAbstract()
    {
        $template = $this->getTemplate();
        $template->setAbstract();
        $template->setName('unittest');
        $template->fillOut();

        $expectedString = 'abstract function unittest();';

        $this->assertEquals($expectedString, $template->andConvertToString());
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
        $template->fillOut();

        $expectedString =
            'function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $template->getIndention() . '$bar = new Bar();' . PHP_EOL .
            $template->getIndention() . '$foo = new Foo();' . PHP_EOL .
            $template->getIndention() . '$foobar->add($bar);' . PHP_EOL .
            $template->getIndention() . '$foobar->add($foo);' . PHP_EOL .
            $template->getIndention() . PHP_EOL .
            $template->getIndention() . 'return $foobar' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testAsFinal()
    {
        $template = $this->getTemplate();
        $template->setFinal();
        $template->setName('unittest');
        $template->fillOut();

        $expectedString =
            'final function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $template->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testAsPrivate()
    {
        $template = $this->getTemplate();
        $template->setPrivate();
        $template->setName('unittest');
        $template->fillOut();

        $expectedString =
            'private function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $template->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testAsProtected()
    {
        $template = $this->getTemplate();
        $template->setProtected();
        $template->setName('unittest');
        $template->fillOut();

        $expectedString =
            'protected function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $template->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testAsPublic()
    {
        $template = $this->getTemplate();
        $template->setName('unittest');
        $template->setPublic();
        $template->fillOut();

        $expectedString =
            'public function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $template->getIndention() . '//@todo implement' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithDocumentation()
    {
$this->markTestIncomplete('todo');
    }

    public function testWithALot()
    {
$this->markTestIncomplete('add documentation');
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
        $template->fillOut();

        $expectedString =
            'final public function unittest()' . PHP_EOL .
            '{' . PHP_EOL .
            $template->getIndention() . '$bar = new Bar();' . PHP_EOL .
            $template->getIndention() . '$foo = new Foo();' . PHP_EOL .
            $template->getIndention() . '$foobar->add($bar);' . PHP_EOL .
            $template->getIndention() . '$foobar->add($foo);' . PHP_EOL .
            $template->getIndention() . PHP_EOL .
            $template->getIndention() . 'return $foobar' . PHP_EOL .
            '}';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    /**
     * @return MethodTemplate
     */
    private function getTemplate()
    {
        return new MethodTemplate();
    }
} 
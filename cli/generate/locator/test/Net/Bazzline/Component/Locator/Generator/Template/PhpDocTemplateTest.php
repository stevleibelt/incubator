<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Template;

use Net\Bazzline\Component\Locator\Generator\Template\PhpDocTemplate;
use PHPUnit_Framework_TestCase;

/**
 * Class PhpDocTemplateTest
 * @package Test\Net\Bazzline\Component\Locator\Generator\Template
 */
class PhpDocTemplateTest extends PHPUnit_Framework_TestCase
{
    public function testWithNoProperties()
    {
        $template = $this->getNewPhpDocTemplate();
        $template->generate();

        $expectedArray = array(
            '/**',
            ' */'
        );
        $expectedString =
            '/**' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testWithComments()
    {
        $template = $this->getNewPhpDocTemplate();
        $template->addComment('Foo');
        $template->addComment('Bar');
        $template->generate();

        $expectedArray = array(
            '/**',
            array(
                ' * Foo',
                ' * Bar'
            ),
            ' */'
        );
        $expectedString =
            '/**' . PHP_EOL .
            ' * Foo' . PHP_EOL .
            ' * Bar' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testWithClass()
    {
        $template = $this->getNewPhpDocTemplate();
        $template->setClass('UnitTest');
        $template->generate();

        $expectedArray = array(
            '/**',
            ' * Class UnitTest',
            ' */'
        );
        $expectedString =
            '/**' . PHP_EOL .
            ' * Class UnitTest' .  PHP_EOL .
            ' */';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testWithPackage()
    {
        $template = $this->getNewPhpDocTemplate();
        $template->setPackage('Unit\Test');
        $template->generate();

        $expectedArray = array(
            '/**',
            ' * @package Unit\Test',
            ' */'
        );
        $expectedString =
            '/**' . PHP_EOL .
            ' * @package Unit\Test' .  PHP_EOL .
            ' */';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testWithParameters()
    {
        $template = $this->getNewPhpDocTemplate();
        $template->addParameter('bar', array('Bar'));
        $template->addParameter('foo', array('Foo'));
        $template->addParameter('fooBar', array('Foo', 'Bar'), 'there is no foo without a bar');
        $template->generate();

        $expectedArray = array(
            '/**',
            array(
                ' * @param Bar $bar',
                ' * @param Foo $foo',
                ' * @param Foo|Bar $fooBar there is no foo without a bar'
            ),
            ' */'
        );
        $expectedString =
            '/**' . PHP_EOL .
            ' * @param Bar $bar' . PHP_EOL .
            ' * @param Foo $foo' . PHP_EOL .
            ' * @param Foo|Bar $fooBar there is no foo without a bar' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testWithReturn()
    {
        $template = $this->getNewPhpDocTemplate();
        $template->setReturn(array('Foo', 'Bar'), 'there is no foo without a bar');
        $template->generate();

        $expectedArray = array(
            '/**',
            ' * @return Foo|Bar there is no foo without a bar',
            ' */'
        );
        $expectedString =
            '/**' . PHP_EOL .
            ' * @return Foo|Bar there is no foo without a bar' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testWithThrows()
    {
        $template = $this->getNewPhpDocTemplate();
        $template->addThrows('BarException');
        $template->addThrows('FooException');
        $template->generate();

        $expectedArray = array(
            '/**',
            ' * @throws BarException|FooException',
            ' */'
        );
        $expectedString =
            '/**' . PHP_EOL .
            ' * @throws BarException|FooException' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testWithToDos()
    {
        $template = $this->getNewPhpDocTemplate();
        $template->addTodoS('implement bar exception');
        $template->addTodoS('implement foo exception');
        $template->generate();

        $expectedArray = array(
            '/**',
            array (
                ' * @todo implement bar exception',
                ' * @todo implement foo exception',
            ),
            ' */'
        );
        $expectedString =
            '/**' . PHP_EOL .
            ' * @todo implement bar exception' . PHP_EOL .
            ' * @todo implement foo exception' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testWithVariable()
    {
        $template = $this->getNewPhpDocTemplate();
        $template->setVariable('foobar', array('Bar', 'Foo'));
        $template->generate();

        $expectedArray = array(
            '/**',
            ' * @var Bar|Foo foobar',
            ' */'
        );
        $expectedString =
            '/**' . PHP_EOL .
            ' * @var Bar|Foo foobar' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testWithAll()
    {
        $template = $this->getNewPhpDocTemplate();
        $template->addComment('Foo');
        $template->addComment('Bar');
        $template->setClass('UnitTest');
        $template->setPackage('Unit\Test');
        $template->addParameter('bar', array('Bar'));
        $template->addParameter('foo', array('Foo'));
        $template->addParameter('fooBar', array('Foo', 'Bar'), 'there is no foo without a bar');
        $template->setReturn(array('Foo', 'Bar'), 'there is no foo without a bar');
        $template->addThrows('BarException');
        $template->addThrows('FooException');
        $template->addTodoS('implement bar exception');
        $template->addTodoS('implement foo exception');
        $template->setVariable('foobar', array('Bar', 'Foo'));
        $template->generate();

        $expectedArray = array(
            '/**',
            array(
                ' * Foo',
                ' * Bar'
            ),
            ' * Class UnitTest',
            ' * @package Unit\Test',
            array (
                ' * @todo implement bar exception',
                ' * @todo implement foo exception',
            ),
            array(
                ' * @param Bar $bar',
                ' * @param Foo $foo',
                ' * @param Foo|Bar $fooBar there is no foo without a bar'
            ),
            ' * @return Foo|Bar there is no foo without a bar',
            ' * @throws BarException|FooException',
            ' * @var Bar|Foo foobar',
            ' */'
        );
        $expectedString =
            '/**' . PHP_EOL .
            ' * Foo' . PHP_EOL .
            ' * Bar' . PHP_EOL .
            ' * Class UnitTest' .  PHP_EOL .
            ' * @package Unit\Test' .  PHP_EOL .
            ' * @todo implement bar exception' . PHP_EOL .
            ' * @todo implement foo exception' . PHP_EOL .
            ' * @param Bar $bar' . PHP_EOL .
            ' * @param Foo $foo' . PHP_EOL .
            ' * @param Foo|Bar $fooBar there is no foo without a bar' . PHP_EOL .
            ' * @return Foo|Bar there is no foo without a bar' . PHP_EOL .
            ' * @throws BarException|FooException' . PHP_EOL .
            ' * @var Bar|Foo foobar' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    /**
     * @return PhpDocTemplate
     */
    private function getNewPhpDocTemplate()
    {
        return new PhpDocTemplate();
    }
} 
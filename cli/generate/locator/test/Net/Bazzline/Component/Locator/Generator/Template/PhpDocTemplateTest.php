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
        $template = $this->getTemplate();
        $template->render();

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
    public function testWithNoPropertiesAndPrefix()
    {
        $template = $this->getTemplate();
        $template->render();
        $prefix = '    ';

        $expectedArray = array(
            '/**',
            ' */'
        );
        $expectedString =
            $prefix . '/**' . PHP_EOL .
            $prefix . ' */';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString($prefix));
    }

    public function testWithComments()
    {
        $template = $this->getTemplate();
        $template->addComment('Foo');
        $template->addComment('Bar');
        $template->render();

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
        $template = $this->getTemplate();
        $template->setClass('UnitTest');
        $template->render();

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
        $template = $this->getTemplate();
        $template->setPackage('Unit\Test');
        $template->render();

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
        $template = $this->getTemplate();
        $template->addParameter('bar', array('Bar'));
        $template->addParameter('foo', array('Foo'));
        $template->addParameter('fooBar', array('Foo', 'Bar'), 'there is no foo without a bar');
        $template->render();

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
        $template = $this->getTemplate();
        $template->setReturn(array('Foo', 'Bar'), 'there is no foo without a bar');
        $template->render();

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

    public function testWithSees()
    {
        $template = $this->getTemplate();
        $template->addSee('https://artodeto@bazzline.net');
        $template->addSee('https://github.com/stevleibelt');
        $template->render();

        $expectedArray = array(
            '/**',
            array (
                ' * @see https://artodeto@bazzline.net',
                ' * @see https://github.com/stevleibelt',
            ),
            ' */'
        );
        $expectedString =
            '/**' . PHP_EOL .
            ' * @see https://artodeto@bazzline.net' . PHP_EOL .
            ' * @see https://github.com/stevleibelt' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedArray, $template->toArray());
        $this->assertEquals($expectedString, $template->toString());
    }

    public function testWithThrows()
    {
        $template = $this->getTemplate();
        $template->addThrows('BarException');
        $template->addThrows('FooException');
        $template->render();

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
        $template = $this->getTemplate();
        $template->addTodoS('implement bar exception');
        $template->addTodoS('implement foo exception');
        $template->render();

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
        $template = $this->getTemplate();
        $template->setVariable('foobar', array('Bar', 'Foo'));
        $template->render();

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
        $template = $this->getTemplate();
        $template->addComment('Foo');
        $template->addComment('Bar');
        $template->setClass('UnitTest');
        $template->setPackage('Unit\Test');
        $template->addParameter('bar', array('Bar'));
        $template->addParameter('foo', array('Foo'));
        $template->addParameter('fooBar', array('Foo', 'Bar'), 'there is no foo without a bar');
        $template->setReturn(array('Foo', 'Bar'), 'there is no foo without a bar');
        $template->addSee('https://artodeto@bazzline.net');
        $template->addSee('https://github.com/stevleibelt');
        $template->addThrows('BarException');
        $template->addThrows('FooException');
        $template->addTodoS('implement bar exception');
        $template->addTodoS('implement foo exception');
        $template->setVariable('foobar', array('Bar', 'Foo'));
        $template->render();

        $expectedArray = array(
            '/**',
            array (
                ' * @see https://artodeto@bazzline.net',
                ' * @see https://github.com/stevleibelt',
            ),
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
            ' * @see https://artodeto@bazzline.net' . PHP_EOL .
            ' * @see https://github.com/stevleibelt' . PHP_EOL .
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
    private function getTemplate()
    {
        return new PhpDocTemplate();
    }
} 
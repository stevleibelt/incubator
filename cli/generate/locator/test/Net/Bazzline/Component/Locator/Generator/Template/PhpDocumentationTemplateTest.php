<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Template;

use Test\Net\Bazzline\Component\Locator\Generator\GeneratorTestCase;

/**
 * Class PhpDocumentationTemplateGeneratorTest
 * @package Test\Net\Bazzline\Component\Locator\Generator\Template
 */
class PhpDocumentationTemplateGeneratorTest extends GeneratorTestCase
{
    public function testWithNoProperties()
    {
        $template = $this->getPhpDocumentationTemplate();
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }
    public function testWithNoPropertiesAndPrefix()
    {
        $template = $this->getPhpDocumentationTemplate();
        $template->fillOut();
        $prefix = '    ';

        $expectedString =
            $prefix . '/**' . PHP_EOL .
            $prefix . ' */';

        $this->assertEquals($expectedString, $template->andConvertToString($prefix));
    }

    public function testWithComments()
    {
        $template = $this->getPhpDocumentationTemplate();
        $template->addComment('Foo');
        $template->addComment('Bar');
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' * Foo' . PHP_EOL .
            ' * Bar' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithClass()
    {
        $template = $this->getPhpDocumentationTemplate();
        $template->setClass('UnitTest');
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' * Class UnitTest' .  PHP_EOL .
            ' */';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithPackage()
    {
        $template = $this->getPhpDocumentationTemplate();
        $template->setPackage('Unit\Test');
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' * @package Unit\Test' .  PHP_EOL .
            ' */';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithParameters()
    {
        $template = $this->getPhpDocumentationTemplate();
        $template->addParameter('bar', array('Bar'));
        $template->addParameter('foo', array('Foo'));
        $template->addParameter('fooBar', array('Foo', 'Bar'), 'there is no foo without a bar');
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' * @param Bar $bar' . PHP_EOL .
            ' * @param Foo $foo' . PHP_EOL .
            ' * @param Foo|Bar $fooBar there is no foo without a bar' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithReturn()
    {
        $template = $this->getPhpDocumentationTemplate();
        $template->setReturn(array('Foo', 'Bar'), 'there is no foo without a bar');
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' * @return Foo|Bar there is no foo without a bar' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithSees()
    {
        $template = $this->getPhpDocumentationTemplate();
        $template->addSee('https://artodeto@bazzline.net');
        $template->addSee('https://github.com/stevleibelt');
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' * @see https://artodeto@bazzline.net' . PHP_EOL .
            ' * @see https://github.com/stevleibelt' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithThrows()
    {
        $template = $this->getPhpDocumentationTemplate();
        $template->addThrows('BarException');
        $template->addThrows('FooException');
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' * @throws BarException|FooException' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithToDos()
    {
        $template = $this->getPhpDocumentationTemplate();
        $template->addTodoS('implement bar exception');
        $template->addTodoS('implement foo exception');
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' * @todo implement bar exception' . PHP_EOL .
            ' * @todo implement foo exception' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithVariable()
    {
        $template = $this->getPhpDocumentationTemplate();
        $template->setVariable('foobar', array('Bar', 'Foo'));
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' * @var Bar|Foo foobar' . PHP_EOL .
            ' */';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithAll()
    {
        $template = $this->getPhpDocumentationTemplate();
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
        $template->fillOut();

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

        $this->assertEquals($expectedString, $template->andConvertToString());
    }
}
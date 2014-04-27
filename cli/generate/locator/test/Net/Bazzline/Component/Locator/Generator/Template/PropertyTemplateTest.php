<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Template;

use Test\Net\Bazzline\Component\Locator\Generator\GeneratorTestCase;

/**
 * Class PropertyTemplateTest
 * @package Test\Net\Bazzline\Component\Locator\Generator\Template
 */
class PropertyTemplateTest extends GeneratorTestCase
{
    /**
     * @expectedException \Net\Bazzline\Component\Locator\Generator\RuntimeException
     * @expectedExceptionMessage name is mandatory
     */
    public function testWithNoProperties()
    {
        $template = $this->getPropertyTemplate();
        $template->fillOut();
    }

    public function testWithName()
    {
        $template = $this->getPropertyTemplate();
        $template->setName('unitTest');
        $template->fillOut();

        $expectedString = '$unitTest;';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithNameAndValue()
    {
        $template = $this->getPropertyTemplate();
        $template->setName('unitTest');
        $template->setValue('\'foobar\'');
        $template->fillOut();

        $expectedString = '$unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithStatic()
    {
        $template = $this->getPropertyTemplate();
        $template->setName('unitTest');
        $template->setIsStatic();
        $template->setValue('\'foobar\'');
        $template->fillOut();

        $expectedString = 'static $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithPrivate()
    {
        $template = $this->getPropertyTemplate();
        $template->setName('unitTest');
        $template->setIsPrivate();
        $template->setValue('\'foobar\'');
        $template->fillOut();

        $expectedString = 'private $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithProtected()
    {
        $template = $this->getPropertyTemplate();
        $template->setName('unitTest');
        $template->setIsProtected();
        $template->setValue('\'foobar\'');
        $template->fillOut();

        $expectedString = 'protected $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithPublic()
    {
        $template = $this->getPropertyTemplate();
        $template->setName('unitTest');
        $template->setIsPublic();
        $template->setValue('\'foobar\'');
        $template->fillOut();

        $expectedString = 'public $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithDocumentation()
    {
        $documentation = $this->getPhpDocumentationTemplate();
        $documentation->setVariable('unitTest', array('string'));
        $documentation->fillOut();
        $template = $this->getPropertyTemplate();
        $template->setDocumentation($documentation);
        $template->setName('unitTest');
        $template->setIsPublic();
        $template->setValue('\'foobar\'');
        $template->fillOut();

        $expectedString =
            '/**' . PHP_EOL .
            ' * @var string $unitTest' . PHP_EOL .
            ' */' . PHP_EOL .
            'public $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }

    public function testWithAll()
    {
        $template = $this->getPropertyTemplate();
        $template->setName('unitTest');
        $template->setIsPublic();
        $template->setIsStatic();
        $template->setValue('\'foobar\'');
        $template->fillOut();

        $expectedString = 'public static $unitTest = \'foobar\';';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }
} 
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Template;

use Test\Net\Bazzline\Component\Locator\Generator\GeneratorTestCase;

/**
 * Class ConstantTemplateTest
 * @package Test\Net\Bazzline\Component\Locator\Generator\Template
 */
class ConstantTemplateTest extends GeneratorTestCase
{
    /**
     * @expectedException \Net\Bazzline\Component\Locator\Generator\RuntimeException
     * @expectedExceptionMessage name and value are mandatory
     */
    public function testWithNoProperties()
    {
        $template = $this->getConstantTemplate();
        $template->fillOut();
    }

    public function testWithNameAndValue()
    {
        $template = $this->getConstantTemplate();
        $template->setName('UNIT_TEST');
        $template->setValue('\'foobar\'');
        $template->fillOut();

        $expectedString = 'const UNIT_TEST = \'foobar\';';

        $this->assertEquals($expectedString, $template->andConvertToString());
    }
}
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Template;

use Test\Net\Bazzline\Component\Locator\Generator\GeneratorTestCase;

/**
 * Class ClassTemplateTest
 * @package Test\Net\Bazzline\Component\Locator\Generator\Template
 */
class ClassTemplateTest extends GeneratorTestCase
{
    /**
     * @expectedException \Net\Bazzline\Component\Locator\Generator\RuntimeException
     * @expectedExceptionMessage name is mandatory
     */
    public function testWithNoProperties()
    {
        $template = $this->getClassTemplate();
        $template->fillOut();
    }
} 
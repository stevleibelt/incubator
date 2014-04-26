<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-26 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Content;

use Net\Bazzline\Component\Locator\Generator\Content\SingleLine;
use PHPUnit_Framework_TestCase;

/**
 * Class SingleLineTest
 * @package Test\Net\Bazzline\Component\Locator\Generator\Content
 */
class SingleLineTest extends PHPUnit_Framework_TestCase
{
    public function testWithoutContent()
    {
        $singleLine = $this->getContent();

        $this->assertFalse($singleLine->hasContent());
        $this->assertEquals('', $singleLine->toString());
    }

    public function testAdd()
    {
        $content = 'there is no foo without a bar';
        $singleLine = $this->getContent();
        $singleLine->add($content);

        $this->assertTrue($singleLine->hasContent());
        $this->assertEquals($content, $singleLine->toString());
    }

    public function testMultipleAdd()
    {
        $content = 'there is no foo without a bar';
        $contentAsArray = explode(' ', $content);
        $singleLine = $this->getContent();

        foreach ($contentAsArray as $part) {
            $singleLine->add($part);
        }

        $this->assertTrue($singleLine->hasContent());
        $this->assertEquals($content, $singleLine->toString());
    }

    public function testMultipleAddWithSeparator()
    {
        $content = 'there:is:no:foo:without:a:bar';
        $contentAsArray = explode(':', $content);
        $singleLine = $this->getContent();

        foreach ($contentAsArray as $part) {
            $singleLine->add($part, ':');
        }

        $this->assertTrue($singleLine->hasContent());
        $this->assertEquals($content, $singleLine->toString());
    }

    /**
     * @return SingleLine
     */
    private function getContent()
    {
        return new SingleLine();
    }
} 
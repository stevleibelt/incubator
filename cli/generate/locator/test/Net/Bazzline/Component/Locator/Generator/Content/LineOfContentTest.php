<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-26 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Content;

use Net\Bazzline\Component\Locator\Generator\Content\LineOfContent;
use PHPUnit_Framework_TestCase;

/**
 * Class LineOfContentTest
 * @package Test\Net\Bazzline\Component\Locator\Generator\Content
 */
class LineOfContentTest extends PHPUnit_Framework_TestCase
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

    public function testClear()
    {
        $content = 'there is no foo without a bar';
        $singleLine = $this->getContent();
        $singleLine->add($content);
        $singleLine->clear();

        $this->assertFalse($singleLine->hasContent());
        $this->assertEquals('', $singleLine->toString());
    }

    public function testClone()
    {
        $content = 'there is no foo without a bar';
        $singleLine = $this->getContent();
        $singleLine->add($content);
        $clonedSingleLine = clone $singleLine;

        $this->assertTrue($singleLine->hasContent());
        $this->assertEquals($content, $singleLine->toString());
        $this->assertFalse($clonedSingleLine->hasContent());
        $this->assertEquals('', $clonedSingleLine->toString());
    }

    /**
     * @return LineOfContent
     */
    private function getContent()
    {
        return new LineOfContent();
    }
} 
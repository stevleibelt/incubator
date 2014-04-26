<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-26 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Content;

use Net\Bazzline\Component\Locator\Generator\Content\Line;
use PHPUnit_Framework_TestCase;

/**
 * Class LineTest
 * @package Test\Net\Bazzline\Component\Locator\Generator\Content
 */
class LineTest extends PHPUnit_Framework_TestCase
{
    public function testWithoutContent()
    {
        $line = $this->getContent();

        $this->assertFalse($line->hasContent());
        $this->assertEquals('', $line->toString());
    }

    public function testAdd()
    {
        $content = 'there is no foo without a bar';
        $line = $this->getContent();
        $line->add($content);

        $this->assertTrue($line->hasContent());
        $this->assertEquals($content, $line->toString());
    }

    public function testMultipleAdd()
    {
        $content = 'there is no foo without a bar';
        $contentAsArray = explode(' ', $content);
        $line = $this->getContent();

        foreach ($contentAsArray as $part) {
            $line->add($part);
        }

        $this->assertTrue($line->hasContent());
        $this->assertEquals($content, $line->toString());
    }

    public function testMultipleAddWithSeparator()
    {
        $content = 'there:is:no:foo:without:a:bar';
        $contentAsArray = explode(':', $content);
        $line = $this->getContent();
        $line->setContentSeparator(':');

        foreach ($contentAsArray as $part) {
            $line->add($part);
        }

        $this->assertTrue($line->hasContent());
        $this->assertEquals($content, $line->toString());
    }

    public function testClear()
    {
        $content = 'there is no foo without a bar';
        $line = $this->getContent();
        $line->add($content);
        $line->clear();

        $this->assertFalse($line->hasContent());
        $this->assertEquals('', $line->toString());
    }

    public function testClone()
    {
        $content = 'there is no foo without a bar';
        $line = $this->getContent();
        $line->add($content);
        $anotherLine = clone $line;

        $this->assertTrue($line->hasContent());
        $this->assertEquals($content, $line->toString());
        $this->assertFalse($anotherLine->hasContent());
        $this->assertEquals('', $anotherLine->toString());
    }

    /**
     * @return Line
     */
    private function getContent()
    {
        return new Line();
    }
} 
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-26 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Content;

use Test\Net\Bazzline\Component\Locator\Generator\GeneratorTestCase;

/**
 * Class LineGeneratorTest
 * @package Test\Net\Bazzline\Component\Locator\LocatorGenerator\Content
 */
class LineGeneratorTest extends GeneratorTestCase
{
    public function testWithoutContent()
    {
        $line = $this->getLine();

        $this->assertFalse($line->hasContent());
        $this->assertEquals('', $line->andConvertToString());
    }

    public function testToString()
    {
        $content = 'there is no foo without a bar';
        $line = $this->getLine();
        $line->add($content);

        $this->assertTrue($line->hasContent());
        $this->assertEquals($content, (string) $line);
    }

    public function testAdd()
    {
        $content = 'there is no foo without a bar';
        $line = $this->getLine();
        $line->add($content);

        $this->assertTrue($line->hasContent());
        $this->assertEquals($content, $line->andConvertToString());
    }

    public function testAddArray()
    {
        $content = 'there is no foo without a bar';
        $contentAsArray = explode(' ', $content);
        $line = $this->getLine();
        $line->add($contentAsArray);

        $this->assertTrue($line->hasContent());
        $this->assertEquals($content, $line->andConvertToString());
    }

    public function testAddNestedArray()
    {
        $contentAsArray = array(
            array('there'),
            array('is'),
            array('no'),
            array('f', 'o', 'o'),
            array('without'),
            array('a'),
            array('b', 'a', 'r')
        );
        $expectedContent = 'there is no f o o without a b a r';
        $line = $this->getLine();
        $line->add($contentAsArray);

        $this->assertTrue($line->hasContent());
        $this->assertEquals($expectedContent, $line->andConvertToString());
    }

    public function testMultipleAdd()
    {
        $content = 'there is no foo without a bar';
        $contentAsArray = explode(' ', $content);
        $line = $this->getLine();

        foreach ($contentAsArray as $part) {
            $line->add($part);
        }

        $this->assertTrue($line->hasContent());
        $this->assertEquals($content, $line->andConvertToString());
    }

    public function testMultipleAddWithSeparator()
    {
        $content = 'there:is:no:foo:without:a:bar';
        $contentAsArray = explode(':', $content);
        $line = $this->getLine();
        $line->setContentSeparator(':');

        foreach ($contentAsArray as $part) {
            $line->add($part);
        }

        $this->assertTrue($line->hasContent());
        $this->assertEquals($content, $line->andConvertToString());
    }

    public function testAddLine()
    {
        $content = 'there is no foo without a bar';
        $contentLine = $this->getLine();
        $contentLine->add($content);
        $line = $this->getLine();
        $line->add($contentLine);

        $this->assertTrue($line->hasContent());
        $this->assertEquals($content, $line->andConvertToString());
    }

    public function testClear()
    {
        $content = 'there is no foo without a bar';
        $line = $this->getLine();
        $line->add($content);
        $line->clear();

        $this->assertFalse($line->hasContent());
        $this->assertEquals('', $line->andConvertToString());
    }

    public function testClone()
    {
        $content = 'there is no foo without a bar';
        $line = $this->getLine();
        $line->add($content);
        $anotherLine = clone $line;

        $this->assertTrue($line->hasContent());
        $this->assertEquals($content, $line->andConvertToString());
        $this->assertFalse($anotherLine->hasContent());
        $this->assertEquals('', $anotherLine->andConvertToString());
    }
}
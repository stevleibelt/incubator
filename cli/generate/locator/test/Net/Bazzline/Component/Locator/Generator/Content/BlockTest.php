<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-26 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator\Content;

use Net\Bazzline\Component\Locator\Generator\Content\Block;
use Net\Bazzline\Component\Locator\Generator\Content\Line;
use PHPUnit_Framework_TestCase;

/**
 * Class BlockTest
 * @package Test\Net\Bazzline\Component\Locator\Generator\Content
 */
class BlockTest extends PHPUnit_Framework_TestCase
{
    public function testWithoutContent()
    {
        $block = $this->getContent();

        $this->assertFalse($block->hasContent());
        $this->assertEquals('', $block->toString());
    }

    public function testAddString()
    {
        $content = 'there is no foo without a bar';
        $block = $this->getContent();
        $block->add($content);

        $this->assertTrue($block->hasContent());
        $this->assertEquals($content, $block->toString());
    }

    public function testAddStringWithIndention()
    {
        $content = 'there is no foo without a bar';
        $block = $this->getContent();
        $block->add($content);
        $indention = '    ';

        $this->assertTrue($block->hasContent());
        $this->assertEquals($indention . $content, $block->toString($indention));
    }

    public function testAddLine()
    {
        $content = new Line('there is no foo without a bar');
        $block = $this->getContent();
        $block->add($content);

        $this->assertTrue($block->hasContent());
        $this->assertEquals($content, $block->toString());
    }

    public function testAddLineWithIndention()
    {
        $content = new Line('there is no foo without a bar');
        $block = $this->getContent();
        $block->add($content);
        $indention = '    ';

        $this->assertTrue($block->hasContent());
        $this->assertEquals($indention . $content, $block->toString($indention));
    }

    public function testAddBlock()
    {
        $content = new Block('there is no foo without a bar');
        $content->add('never ever');
        $block = $this->getContent();
        $block->add($content);

        $expectedContent =
            'there is no foo without a bar' . PHP_EOL .
            'never ever';
        $this->assertTrue($block->hasContent());
        $this->assertEquals($expectedContent, $block->toString());
    }

    public function testAddBlockWithIndention()
    {
        $content = new Block('there is no foo without a bar');
        $content->add('never ever');
        $block = $this->getContent();
        $block->add($content);
        $indention = '    ';

        $expectedContent =
            $indention . $indention . 'there is no foo without a bar' . PHP_EOL .
            $indention . $indention . 'never ever';
        $this->assertTrue($block->hasContent());
        $this->assertEquals($expectedContent, $block->toString($indention));
    }

    public function testMultipleAdd()
    {
        $content = 'there is no foo without a bar';
        $contentAsArray = explode(' ', $content);
        $block = $this->getContent();

        foreach ($contentAsArray as $part) {
            $block->add($part);
        }

        $this->assertTrue($block->hasContent());
        $this->assertEquals(implode(PHP_EOL, $contentAsArray), $block->toString());
    }

    public function testClear()
    {
        $content = 'there is no foo without a bar';
        $block = $this->getContent();
        $block->add($content);
        $block->clear();

        $this->assertFalse($block->hasContent());
        $this->assertEquals('', $block->toString());
    }

    public function testClone()
    {
        $content = 'there is no foo without a bar';
        $block = $this->getContent();
        $block->add($content);
        $anotherLine = clone $block;

        $this->assertTrue($block->hasContent());
        $this->assertEquals($content, $block->toString());
        $this->assertFalse($anotherLine->hasContent());
        $this->assertEquals('', $anotherLine->toString());
    }

    /**
     * @return Block
     */
    private function getContent()
    {
        return new Block();
    }
}
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-18
 */

namespace Test\Net\Bazzline\Component\ArrayMerger;

use Net\Bazzline\Component\ArrayMerger\ArrayMerger;
use PHPUnit_Framework_TestCase;

class ArrayMergerTest extends PHPUnit_Framework_TestCase
{
    private $arrayMerger;

    protected function setUp()
    {
        $this->arrayMerger = new ArrayMerger();
    }

    public static function testCaseProvider()
    {
        $testCases = array(
            'source and target are empty' => array(
                'expectedArray' => array(),
                'preserveNumericKeys' => false,
                'source' => array(),
                'target' => array()
            ),
            'source is simple array and target are empty' => array(
                'expectedArray' => array('foo', 'bar', 'foobar'),
                'preserveNumericKeys' => false,
                'source' => array('foo', 'bar', 'foobar'),
                'target' => array()
            ),
            'source is empty and target is a simple array' => array(
                'expectedArray' => array('foo', 'bar', 'foobar'),
                'preserveNumericKeys' => false,
                'source' => array(),
                'target' => array('foo', 'bar', 'foobar')
            ),
            'source is simple array and target is a simple array' => array(
                'expectedArray' => array('foo', 'bar', 'foobar', 'baz'),
                'preserveNumericKeys' => false,
                'source' => array('foobar', 'baz'),
                'target' => array('foo', 'bar')
            ),
            'source is simple array and target is a simple array but same value' => array(
                'expectedArray' => array('foo', 'bar', 'baz', 'foobar', 'baz'),
                'preserveNumericKeys' => false,
                'source' => array('foobar', 'baz'),
                'target' => array('foo', 'bar', 'baz')
            )
        );

        return $testCases;
    }

    /**
     * @dataProvider testCaseProvider
     */
    public function testMerge($expectedArray, $preserveNumericKeys, $source, $target)
    {
        $array = $this->arrayMerger->merge($target, $source, $preserveNumericKeys);
        $this->assertEquals($expectedArray, $array);
    }
}

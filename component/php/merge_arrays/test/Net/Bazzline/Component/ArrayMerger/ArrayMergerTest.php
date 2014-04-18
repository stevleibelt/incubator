<?php

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

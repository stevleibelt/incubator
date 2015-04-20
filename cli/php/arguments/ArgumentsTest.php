<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-04-18 
 */

require_once __DIR__ . '/Arguments.php';
require_once __DIR__ . '/vendor/autoload.php';

class ArgumentsTest extends PHPUnit_Framework_TestCase
{
    public function testWithNoArgv()
    {
        $arguments = $this->getNewArguments();

        $this->assertFalse($arguments->hasArguments());
        $this->assertFalse($arguments->hasLists());
        $this->assertFalse($arguments->hasFlags());
        $this->assertFalse($arguments->hasValues());
    }

    /**
     * @return array
     */
    public function testWithArgumentsProvider()
    {
        return array(
            'empty argv' => array(
                'argv'      => array(),
                'arguments' => array(),
                'flags'     => array(),
                'lists'     => array(),
                'values'    => array()
            ),
            'only file name argument' => array(
                'argv'      => array(
                    __FILE__
                ),
                'arguments' => array(),
                'flags'     => array(),
                'lists'     => array(),
                'values'    => array()
            ),
            'one value' => array(
                'argv'      => array(
                    __FILE__,
                    'foo'
                ),
                'arguments' => array(
                    'foo'
                ),
                'flags'     => array(),
                'lists'     => array(),
                'values'    => array(
                    'foo'
                )
            ),
            'one short trigger' => array(
                'argv'      => array(
                    __FILE__,
                    '-f'
                ),
                'arguments' => array(
                    '-f'
                ),
                'flags'     => array(
                    'f'
                ),
                'lists'     => array(),
                'values'    => array()
            ),
            'one long trigger' => array(
                'argv'      => array(
                    __FILE__,
                    '--foobar'
                ),
                'arguments' => array(
                    '--foobar'
                ),
                'flags'     => array(
                    'foobar'
                ),
                'lists'     => array(),
                'values'    => array()
            ),
            'one short list without quotation mark' => array(
                'argv'      => array(
                    __FILE__,
                    '-foo'
                ),
                'arguments' => array(
                    '-foo'
                ),
                'flags'     => array(),
                'lists'     => array(
                    'f' => array(
                        'oo'
                    )
                ),
                'values'    => array()
            ),
            'one short list with quotation mark' => array(
                'argv'      => array(
                    __FILE__,
                    '-f"oo"'
                ),
                'arguments' => array(
                    '-f"oo"'
                ),
                'flags'  => array(),
                'lists'     => array(
                    'f' => array(
                        'oo'
                    )
                ),
                'values'    => array()
            ),
            'one long list without quotation mark' => array(
                'argv'      => array(
                    __FILE__,
                    '--foobar=baz'
                ),
                'arguments' => array(
                    '--foobar=baz'
                ),
                'flags'  => array(),
                'lists'     => array(
                    'foobar' => array(
                        'baz'
                    )
                ),
                'values'    => array()
            ),
            'one long list with quotation mark' => array(
                'argv'      => array(
                    __FILE__,
                    '--foobar="baz"'
                ),
                'arguments' => array(
                    '--foobar="baz"'
                ),
                'flags'  => array(),
                'lists'     => array(
                    'foobar' => array(
                        'baz'
                    )
                ),
                'values'    => array()
            ),
            'complex example' => array(
                'argv'      => array(
                    __FILE__,
                    '--foobar="foo"',
                    '--foobar"baz"',
                    '--foobar=bar',
                    'foobar',
                    '-f=foo',
                    '-f"baz"',
                    '-f="bar"',
                    '-b',
                    'foo',
                    '-z'
                ),
                'arguments' => array(
                    '--foobar="foo"',
                    '--foobar"baz"',
                    '--foobar=bar',
                    'foobar',
                    '-f=foo',
                    '-f"baz"',
                    '-f="bar"',
                    '-b',
                    'foo',
                    '-z'
                ),
                'flags'  => array(
                    'b',
                    'z'
                ),
                'lists'     => array(
                    'foobar'    => array(
                        'foo',
                        'baz',
                        'bar'
                    ),
                    'f'         => array(
                        'foo',
                        'baz',
                        'bar'
                    )
                ),
                'values'    => array(
                    'foobar',
                    'foo'
                )
            )
        );
    }

    /**
     * @dataProvider testWithArgumentsProvider
     * @param array $argv
     * @param array $expectedArguments
     * @param array $expectedFlags
     * @param array $expectedLists
     * @param array $expectedValues
     */
    public function testWithArguments(array $argv, array $expectedArguments, array $expectedFlags, array $expectedLists, array $expectedValues)
    {
        $arguments = $this->getNewArguments($argv);

        $this->assertEquals((!empty($expectedArguments)), $arguments->hasArguments());
        $this->assertEquals((!empty($expectedFlags)), $arguments->hasFlags());
        $this->assertEquals((!empty($expectedLists)), $arguments->hasLists());
        $this->assertEquals((!empty($expectedValues)), $arguments->hasValues());

        $this->assertEquals($expectedArguments, $arguments->getArguments());
        $this->assertEquals($expectedFlags, $arguments->getFlags());
        $this->assertEquals($expectedLists, $arguments->getLists());
        $this->assertEquals($expectedValues, $arguments->getValues());

        foreach ($expectedFlags as $name) {
            $this->assertTrue($arguments->hasFlag($name));
        }

        foreach ($expectedLists as $name => $values) {
            $this->assertTrue($arguments->hasList($name));
            $this->assertEquals($values, $arguments->getList($name));
        }
    }

    /**
     * @param null|array $argv
     * @return Arguments
     */
    private function getNewArguments($argv = null)
    {
        return new Arguments($argv);
    }
}
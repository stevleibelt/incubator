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
        $this->assertFalse($arguments->hasTriggers());
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
                'lists'     => array(),
                'triggers'  => array(),
                'values'    => array()
            ),
            'only file name argument' => array(
                'argv'      => array(
                    __FILE__
                ),
                'arguments' => array(),
                'lists'     => array(),
                'triggers'  => array(),
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
                'lists'     => array(),
                'triggers'  => array(),
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
                'lists'     => array(),
                'triggers'  => array(
                    'f'
                ),
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
                'lists'     => array(),
                'triggers'  => array(
                    'foobar'
                ),
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
                'lists'     => array(
                    'f' => array(
                        'oo'
                    )
                ),
                'triggers'  => array(),
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
                'lists'     => array(
                    'f' => array(
                        'oo'
                    )
                ),
                'triggers'  => array(),
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
                'lists'     => array(
                    'foobar' => array(
                        'baz'
                    )
                ),
                'triggers'  => array(),
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
                'lists'     => array(
                    'foobar' => array(
                        'baz'
                    )
                ),
                'triggers'  => array(),
                'values'    => array()
            )
        );
    }

    /**
     * @dataProvider testWithArgumentsProvider
     * @param array $argv
     * @param array $expectedArguments
     * @param array $expectedLists
     * @param array $expectedTriggers
     * @param array $expectedValues
     */
    public function testWithArguments(array $argv, array $expectedArguments, array $expectedLists, array $expectedTriggers, array $expectedValues)
    {
        $arguments = $this->getNewArguments($argv);

        $this->assertEquals((!empty($expectedArguments)), $arguments->hasArguments());
        $this->assertEquals((!empty($expectedLists)), $arguments->hasLists());
        $this->assertEquals((!empty($expectedTriggers)), $arguments->hasTriggers());
        $this->assertEquals((!empty($expectedValues)), $arguments->hasValues());

        $this->assertEquals($expectedArguments, $arguments->getArguments());
        $this->assertEquals($expectedLists, $arguments->getLists());
        $this->assertEquals($expectedTriggers, $arguments->getTriggers());
        $this->assertEquals($expectedValues, $arguments->getValues());

        //@todo test getValue()/getList()/getTrigger()/...
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
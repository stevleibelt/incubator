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
     * @param null|array $argv
     * @return Arguments
     */
    private function getNewArguments($argv = null)
    {
        return new Arguments($argv);
    }
}
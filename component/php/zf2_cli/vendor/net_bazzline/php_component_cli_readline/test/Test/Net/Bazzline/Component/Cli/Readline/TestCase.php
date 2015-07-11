<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-05 
 */

namespace Test\Net\Bazzline\Component\Cli\Readline;

use Mockery;
use Net\Bazzline\Component\Cli\Readline\Configuration\Validator;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * @return Validator
     */
    protected function getNewValidator()
    {
        return new Validator();
    }
}
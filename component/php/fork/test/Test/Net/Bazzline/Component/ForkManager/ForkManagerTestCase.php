<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2014-07-28
 */

namespace Test\Net\Bazzline\Component\ForkManager;

use Mockery;
use PHPUnit_Framework_TestCase;

/**
 * Class ForkManagerTestCase
 * @package Test\Net\Bazzline\Component\ForkManager
 */
class ForkManagerTestCase extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\ForkManager\TaskManager
     */
    protected function getMockOfTaskManager()
    {
        return Mockery::mock('Net\Bazzline\Component\ForkManager\TaskManager');
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\ForkManager\AbstractTask
     */
    protected function getMockOfAbstractTask()
    {
        return Mockery::mock('Net\Bazzline\Component\ForkManager\AbstractTask');
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\ForkManager\AbstractTask
     */
    protected function getPartialMockOfAbstractTask()
    {
        return Mockery::mock('Net\Bazzline\Component\ForkManager\AbstractTask[execute]');
    }
}
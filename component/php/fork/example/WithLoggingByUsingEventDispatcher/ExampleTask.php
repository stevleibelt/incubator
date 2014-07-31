<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-31
 */

namespace Net\Bazzline\Component\ForkManager\Example\WithLoggingByUsingEventDispatcher;

use Net\Bazzline\Component\ForkManager\AbstractTask;

/**
 * Class ExampleTask
 * @package Net\Bazzline\Component\Fork\Example\WithLoggingByUsingEventDispatcher
 */
class ExampleTask extends AbstractTask
{
    /**
     * @throws \Net\Bazzline\Component\ForkManager\RuntimeException
     */
    public function execute()
    {
        sleep(rand(3, 7));
    }
}
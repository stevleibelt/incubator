<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-23 
 */

namespace Net\Bazzline\Component\ForkManager\Example\WithMoreTasksThenOpenThreads;

use Net\Bazzline\Component\ForkManager\AbstractTask;

/**
 * Class ExampleTask
 * @package Net\Bazzline\Component\Fork\Example\WithMoreTasksThenOpenThreads
 */
class ExampleTask extends AbstractTask
{
    /**
     * @throws \Net\Bazzline\Component\ForkManager\RuntimeException
     */
    public function execute()
    {
        $identifier = 'task (' . posix_getpid() . ' / ' . $this->getParentProcessId() . ')';
        $startTime = time();

        echo $identifier . ' says hello' . PHP_EOL;
        sleep(rand(3, 7));
        echo $identifier . ' says goodbye' . PHP_EOL;
        echo $identifier . ' runtime: ' . (time() - $startTime) . ' seconds' . PHP_EOL;
        echo $identifier . ' memory usage: ' . (memory_get_usage(true)) . ' bytes' . PHP_EOL;
    }
}
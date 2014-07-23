<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-23 
 */

namespace Net\Bazzline\Component\Fork\Example\MoreTasksThenOpenThreads;

use Net\Bazzline\Component\Fork\AbstractTask;

/**
 * Class ExampleTask
 * @package Net\Bazzline\Component\Fork\Example\MoreTasksThenOpenThreads
 */
class ExampleTask extends AbstractTask
{
    /**
     * @throws \Net\Bazzline\Component\Fork\RuntimeException
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
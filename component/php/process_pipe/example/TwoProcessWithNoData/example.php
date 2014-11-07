<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-11-08 
 */

namespace De\Leibelt\ProcessPipe\Example\TwoProcessNoData;

use De\Leibelt\ProcessPipe\ExecutableInterface;
use De\Leibelt\ProcessPipe\Pipe;

require_once __DIR__ . '/../autoload.php';

/**
 * Class ProcessOne
 */
class ProcessOne implements ExecutableInterface
{
    /**
     * @param mixed $data
     * @return mixed
     * @throws \De\Leibelt\ProcessPipe\ExecutableException
     */
    public function execute($data = null)
    {
        echo __METHOD__ . PHP_EOL;
        sleep(1);

        return $data;
    }
}

/**
 * Class ProcessTwo
 */
class ProcessTwo implements ExecutableInterface
{
    /**
     * @param mixed $data
     * @return mixed
     * @throws \De\Leibelt\ProcessPipe\ExecutableException
     */
    public function execute($data = null)
    {
        echo __METHOD__ . PHP_EOL;

        return $data;
    }
}

$pipe = new Pipe();
$processOne = new ProcessOne();
$processTwo = new ProcessTwo();

$pipe->pipe($processOne);
$pipe->pipe($processTwo);

$pipe->execute();

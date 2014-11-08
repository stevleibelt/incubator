<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-11-08 
 */

namespace De\Leibelt\ProcessPipe\Example\NoInput;

use De\Leibelt\ProcessPipe\ExecutableInterface;
use De\Leibelt\ProcessPipe\Pipe;

require_once __DIR__ . '/../autoload.php';

/**
 * Class ProcessOne
 */
class ProcessOne implements ExecutableInterface
{
    /**
     * @param mixed $input
     * @return mixed
     * @throws \De\Leibelt\ProcessPipe\ExecutableException
     */
    public function execute($input = null)
    {
        echo __METHOD__ . PHP_EOL;
        sleep(1);

        return $input;
    }
}

/**
 * Class ProcessTwo
 */
class ProcessTwo implements ExecutableInterface
{
    /**
     * @param mixed $input
     * @return mixed
     * @throws \De\Leibelt\ProcessPipe\ExecutableException
     */
    public function execute($input = null)
    {
        echo __METHOD__ . PHP_EOL;

        return $input;
    }
}

$pipe = new Pipe();
$processOne = new ProcessOne();
$processTwo = new ProcessTwo();

$pipe->pipe($processOne);
$pipe->pipe($processTwo);

$pipe->execute();

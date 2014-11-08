<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-11-08 
 */

namespace De\Leibelt\ProcessPipe\Example\FailingExecution;

use De\Leibelt\ProcessPipe\ExecutableException;
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
        throw new ExecutableException(__METHOD__ . ' has failed');
    }
}

$pipe = new Pipe(
    new ProcessOne(),
    new ProcessTwo()
);

try {
    $pipe->execute();
} catch (ExecutableException $exception) {
    echo 'error occurred:' . PHP_EOL;
    echo $exception->getMessage() . PHP_EOL;
}

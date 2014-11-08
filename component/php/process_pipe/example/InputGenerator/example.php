<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-11-08 
 */

namespace De\Leibelt\ProcessPipe\Example\InputGenerator;

use De\Leibelt\ProcessPipe\ExecutableInterface;
use De\Leibelt\ProcessPipe\Pipe;

require_once __DIR__ . '/../autoload.php';

/**
 * Class DataGeneratorProcess
 */
class DataGeneratorProcess implements ExecutableInterface
{
    /**
     * @param mixed $input
     * @return mixed
     * @throws \De\Leibelt\ProcessPipe\ExecutableException
     */
    public function execute($input = null)
    {
        $input = array();
        $input[] = array(
            microtime(true),
            'debug',
            'new generated log data'
        );

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
        $input[] = array(
            microtime(true),
            'debug',
            'hello world'
        );

        return $input;
    }
}

$pipe = new Pipe(
    new DataGeneratorProcess(),
    new ProcessTwo()
);

$output = $pipe->execute();

foreach ($output as $log) {
    echo '[' . $log[0] . '] [' . $log[1] . '] - ' . $log[2] . PHP_EOL;
}

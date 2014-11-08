<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-11-08 
 */

namespace De\Leibelt\ProcessPipe\Example\WithDataGenerator;

use De\Leibelt\ProcessPipe\ExecutableInterface;
use De\Leibelt\ProcessPipe\Pipe;

require_once __DIR__ . '/../autoload.php';

/**
 * Class DataGeneratorProcess
 */
class DataGeneratorProcess implements ExecutableInterface
{
    /**
     * @param mixed $data
     * @return mixed
     * @throws \De\Leibelt\ProcessPipe\ExecutableException
     */
    public function execute($data = null)
    {
        $data = array();
        $data[] = array(
            microtime(true),
            'debug',
            'new generated log data'
        );

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
        $data[] = array(
            microtime(true),
            'debug',
            'hello world'
        );

        return $data;
    }
}

$pipe = new Pipe(
    new DataGeneratorProcess(),
    new ProcessTwo()
);

$data = $pipe->execute();

foreach ($data as $log) {
    echo '[' . $log[0] . '] [' . $log[1] . '] - ' . $log[2] . PHP_EOL;
}

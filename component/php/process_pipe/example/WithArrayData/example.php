<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-11-08 
 */

namespace De\Leibelt\ProcessPipe\Example\WithArrayData;

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
        $data['name'] = 'bar';
        $data['steps'][] = __METHOD__;
        $data['times'][] = microtime(true);

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
        $data['name'] = 'foobar';
        $data['steps'][] = __METHOD__;
        $data['times'][] = microtime(true);

        return $data;
    }
}

$data = array(
    'name' => 'foo',
    'steps' => array(),
    'times' => array()
);
$pipe = new Pipe();

$pipe->pipe(
    new ProcessOne(),
    new ProcessTwo()
);

echo 'data before process pipe.' . PHP_EOL;
echo var_export($data, true) . PHP_EOL;

$data = $pipe->execute($data);

echo 'data after process pipe.' . PHP_EOL;
echo var_export($data, true) . PHP_EOL;

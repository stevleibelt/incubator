<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-11-09
 */

namespace De\Leibelt\ProcessPipe\Example\WithDataTypeValidation;

use De\Leibelt\ProcessPipe\ExecutableException;
use De\Leibelt\ProcessPipe\ExecutableInterface;
use De\Leibelt\ProcessPipe\Pipe;
use Exception;

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
        $data .= ' ' . __METHOD__;

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
        if (!is_array($data)) {
            throw new ExecutableException('data must be type of array');
        }

        $data[] = __METHOD__;

        return $data;
    }
}

$data = 'string';

$pipe = new Pipe();

$pipe->pipe(
    new ProcessOne(),
    new ProcessTwo()
);

try {
    $data = $pipe->execute($data);
    echo $data . PHP_EOL;
} catch (Exception $exception) {
    echo 'caught exception with message: ' . $exception->getMessage() . PHP_EOL;
}

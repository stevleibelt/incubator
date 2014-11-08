<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-11-09
 */

namespace De\Leibelt\ProcessPipe\Example\InputValidator;

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
     * @param mixed $input
     * @return mixed
     * @throws \De\Leibelt\ProcessPipe\ExecutableException
     */
    public function execute($input = null)
    {
        $input .= ' ' . __METHOD__;

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
        if (!is_array($input)) {
            throw new ExecutableException('input must be type of array');
        }

        $input[] = __METHOD__;

        return $input;
    }
}

$input = 'string';

$pipe = new Pipe();

$pipe->pipe(
    new ProcessOne(),
    new ProcessTwo()
);

try {
    $output = $pipe->execute($input);
    echo $output . PHP_EOL;
} catch (Exception $exception) {
    echo 'caught exception with message: ' . $exception->getMessage() . PHP_EOL;
}

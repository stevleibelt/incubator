<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-11-08 
 */

namespace De\Leibelt\ProcessPipe\Example\WithDataTransformer;

use De\Leibelt\ProcessPipe\ExecutableException;
use De\Leibelt\ProcessPipe\ExecutableInterface;
use De\Leibelt\ProcessPipe\Pipe;
use stdClass;

require_once __DIR__ . '/../autoload.php';

/**
 * Class ObjectToArrayTransformer
 */
class ObjectToArrayTransformer implements ExecutableInterface
{
    /**
     * @param mixed $data
     * @return mixed
     * @throws \De\Leibelt\ProcessPipe\ExecutableException
     */
    public function execute($data = null)
    {
        if (!is_object($data)) {
            throw new ExecutableException('data must be instance of object');
        }

        $array = array();

        foreach (get_object_vars($data) as $property => $value) {
            $array[$property] = $value;
        }

        return $array;
    }
}

/**
 * Class ArrayToJSONTransformer
 * @package De\Leibelt\ProcessPipe\Example\WithDataTransformer
 */
class ArrayToJSONTransformer implements ExecutableInterface
{
    /**
     * @param mixed $data
     * @return mixed
     * @throws ExecutableException
     */
    public function execute($data = null)
    {
        if (!is_array($data)) {
            throw new ExecutableException('data must be an array');
        }

        return json_encode($data);
    }
}

$pipe = new Pipe(
    new ObjectToArrayTransformer(),
    new ArrayToJSONTransformer()
);

$object = new stdClass();

$object->foo = 'bar';
$object->bar = 'foo';
$object->foobar = 'barfoo';

echo $pipe->execute($object) . PHP_EOL;

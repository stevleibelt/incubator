<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-05 
 */

namespace Net\Bazzline\Component\Cli\Autocomplete\Configuration;

use Net\Bazzline\Component\GenericAgreement\Data\ValidatorInterface;
use Net\Bazzline\Component\GenericAgreement\Exception\InvalidArgument;

class Validator implements ValidatorInterface
{
    /** @var string */
    private $message;

    /** @var string */
    private $trace;

    /**
     * @param mixed $data
     * @return boolean
     */
    public function isValid($data)
    {
        $this->resetMessageAndTrace();

        try {
            $this->validate($data);
            $isValid = true;
        } catch (InvalidArgument $exception) {
            $this->message  = $exception->getMessage();
            $this->trace    = $exception->getTraceAsString();
            $isValid = false;
        }

        return $isValid;
    }

    /**
     * @return null|string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return null|string
     */
    public function getTrace()
    {
        return $this->trace;
    }

    private function resetMessageAndTrace()
    {
        $this->message  = null;
        $this->trace    = null;
    }

    /**
     * @param array $configuration
     * @param null $path
     */
    private function validate($configuration, $path = null)
    {
        if (!is_array($configuration)) {
            throw new InvalidArgument('configuration ' . (is_null($path) ? '' : ' in path "' . $path . '" ') . 'must be an array');
        }

        if (empty($configuration)) {
            throw new InvalidArgument('configuration ' . (is_null($path) ? '' : ' in path "' . $path . '" ') . 'can not be empty');
        }

        foreach ($configuration as $index => $arrayOrCallable) {
            $currentPath = (is_null($path)) ? $index : $path . '/' . $index;

            if (is_string($arrayOrCallable)) {
                if (!is_callable($arrayOrCallable)) {
                    throw new InvalidArgument('method in path "' . $currentPath . '" must be callable');
                }
            } else if (is_array($arrayOrCallable)) {
                $object = current($arrayOrCallable);

                if (is_object($object)) {
                    $methodName = $arrayOrCallable[1];
                    if (!method_exists($object, $methodName)) {
                        throw new InvalidArgument(
                            'provided instance of "' . get_class($object) . '" in path "' . $currentPath . '" does not have the method "' . $methodName . '"'
                        );
                    }
                } else {
                    $this->validate($arrayOrCallable, $currentPath);
                }
            } else {
                throw new InvalidArgument(
                    'can not handle value "' . var_export($arrayOrCallable, true) . '" in path "' . $currentPath . '"'
                );
            }
        }
    }
}
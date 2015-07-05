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

    /**
     * @param mixed $data
     * @return boolean
     */
    public function isValid($data)
    {
        $this->resetMessage();

        try {
            $this->validate($data);
            $isValid = true;
        } catch (InvalidArgument $exception) {
            $this->setMessage($exception->getMessage());
            $isValid = false;
        }

        return $isValid;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function hasMessage()
    {
        return ($this->message !== '');
    }

    /**
     * @param string $message
     */
    private function setMessage($message)
    {
        $this->message = (string) $message;
    }

    private function resetMessage()
    {
        $this->message = '';
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
            $path = (is_null($path)) ? $index : $path . '/' . $index;

            if (is_string($arrayOrCallable)) {
                if(!is_callable($arrayOrCallable)) {
                    throw new InvalidArgument('method in path "' . $path . '" must be callable');
                }
            } else if (is_array($arrayOrCallable)) {
                $object = current($arrayOrCallable);

                if (is_object($object)) {
                    $methodName = $arrayOrCallable[1];
                    if (!method_exists($object, $methodName)) {
                        throw new InvalidArgument(
                            'provided instance of "' . get_class($object) . '" in path "' . $path . '" does not have the method "' . $methodName . '"'
                        );
                    }
                } else {
                    $this->validate($arrayOrCallable, $path);
                }
            } else {
                throw new InvalidArgument(
                    'can not handle value "' . var_export($arrayOrCallable, true) . '" in path "' . $path . '"'
                );
            }
        }
    }
}
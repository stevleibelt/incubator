<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-05 
 */

namespace Net\Bazzline\Component\Cli\Autocomplete\Configuration;

use Net\Bazzline\Component\GenericAgreement\Data\AssemblageInterface;
use Net\Bazzline\Component\GenericAgreement\Exception\InvalidArgument;
use Net\Bazzline\Component\GenericAgreement\Process\ExecutableInterface;

class Assembler implements AssemblageInterface
{
    /** @var Executable */
    private $executable;

    /** @var Validator */
    private $validator;

    /**
     * @param mixed $data
     * @return mixed
     * @throws ExecutableInterface
     */
    public function assemble($data)
    {
        $configuration  = array();
        $validator      = $this->validator;

        if ($validator->isValid($data)) {
            foreach ($data as $index => $arrayOrCallable) {
                $isCallable = $this->isCallable($arrayOrCallable);

                if ($isCallable) {
                    $executable = $this->getNewExecutable();
                    $executable->setExecutable($arrayOrCallable);
                    $configuration[$index] = $executable;
                } else {
                    $configuration[$index] = $this->assemble($arrayOrCallable);
                }
            }
        } else {
            throw new InvalidArgument($validator->getMessage() . PHP_EOL . $validator->getTrace());
        }

        return $configuration;
    }

    /**
     * @param Executable $executable
     * @return $this
     */
    public function setExecutable(Executable $executable)
    {
        $this->executable = $executable;

        return $this;
    }

    /**
     * @param Validator $validator
     * @return $this
     */
    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * @param string|array $arrayOrCallable
     * @return bool
     */
    private function isCallable($arrayOrCallable)
    {
        $isCallable = false;

        if (is_string($arrayOrCallable)) {
            $isCallable = is_callable($arrayOrCallable);
        } else if (is_array($arrayOrCallable)) {
            $object = current($arrayOrCallable);

            if (is_object($object)) {
                $methodName = $arrayOrCallable[1];
                $isCallable = method_exists($object, $methodName);
            }
        }

        return $isCallable;
    }

    /**
     * @return Executable
     */
    private function getNewExecutable()
    {
        return clone $this->executable;
    }
}
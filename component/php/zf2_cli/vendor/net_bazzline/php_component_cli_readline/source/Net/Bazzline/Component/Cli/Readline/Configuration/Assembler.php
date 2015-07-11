<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-05 
 */

namespace Net\Bazzline\Component\Cli\Readline\Configuration;

use Closure;
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
        $validator = $this->validator;

        if ($validator->isValid($data)) {
            $configuration = $this->build($data);
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
     * @param array $data
     * @return array
     */
    private function build($data)
    {
        $configuration  = array();

        foreach ($data as $index => $arrayOrCallable) {
            $isCallable = $this->isCallable($arrayOrCallable);

            if ($isCallable) {
                $executable = $this->getNewExecutable();
                $executable->setExecutable($arrayOrCallable);
                $configuration[$index] = $executable;
            } else {
                $configuration[$index] = $this->build($arrayOrCallable);
            }
        }

        return $configuration;
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
        } else if ($arrayOrCallable instanceof Closure) {
            $isCallable = true;
        } else if (is_array($arrayOrCallable)) {
            $object     = current($arrayOrCallable);
            $isClosure  = ($object instanceof Closure);

            if ($isClosure) {
                $isCallable = false;
            } else if (is_object($object)) {
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

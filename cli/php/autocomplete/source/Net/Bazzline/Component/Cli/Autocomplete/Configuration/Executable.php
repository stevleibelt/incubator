<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-05 
 */

namespace Net\Bazzline\Component\Cli\Autocomplete\Configuration;

use Net\Bazzline\Component\GenericAgreement\Exception\ExceptionInterface;
use Net\Bazzline\Component\GenericAgreement\Process\ExecutableInterface;

class Executable implements ExecutableInterface
{
    /** @var string|array */
    private $executable;

    /**
     * @param string|array $arrayOrString
     * @return $this
     */
    public function setExecutable($arrayOrString)
    {
        $this->executable = $arrayOrString;

        return $this;
    }

    /**
     * @param mixed $data
     * @return mixed
     * @throws ExceptionInterface
     */
    public function execute($data)
    {
        $executable = $this->executable;

        if (is_null($data)) {
            call_user_func($executable);
        } else {
            call_user_func_array($executable, $data);
        }
    }
}
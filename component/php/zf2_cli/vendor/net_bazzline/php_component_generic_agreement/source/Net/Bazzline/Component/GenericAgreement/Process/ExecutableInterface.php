<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-01
 */

namespace Net\Bazzline\Component\GenericAgreement\Process;

use Net\Bazzline\Component\GenericAgreement\Exception\ExceptionInterface;

/**
 * Interface ExecutableInterface
 *
 * @package Net\Bazzline\Component\GenericAgreement\Process
 */
interface ExecutableInterface
{
    /**
     * @param mixed $data
     * @return mixed
     * @throws ExceptionInterface
     */
    public function execute($data);
}
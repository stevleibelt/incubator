<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-01
 */

namespace Net\Bazzline\Component\GenericAgreement\Data;

use Net\Bazzline\Component\GenericAgreement\Exception\ExceptionInterface;

interface AssemblageInterface
{
    /**
     * @param mixed $data
     * @return mixed
     * @throws ExceptionInterface
     */
    public function assemble($data);
}

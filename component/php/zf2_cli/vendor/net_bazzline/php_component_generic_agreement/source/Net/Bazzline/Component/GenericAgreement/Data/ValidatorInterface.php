<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-01
 */

namespace Net\Bazzline\Component\GenericAgreement\Data;

use Net\Bazzline\Component\GenericAgreement\Exception\ExceptionInterface;

interface ValidatorInterface
{
    /**
     * @param mixed $data
     * @return boolean
     * @throws ExceptionInterface
     */
    public function isValid($data);
}
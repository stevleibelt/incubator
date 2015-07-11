<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-01
 */

namespace Net\Bazzline\Component\GenericAgreement\Data;

use Net\Bazzline\Component\GenericAgreement\Exception\ExceptionInterface;

interface FilterableInterface
{
    /**
     * @param mixed $data
     * @return null|mixed
     * @throws ExceptionInterface
     */
    public function filter($data);
}

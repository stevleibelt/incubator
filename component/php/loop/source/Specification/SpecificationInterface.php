<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-08-31
 */
namespace Net\Bazzline\Component\Loop;

interface SpecificationInterface
{
    /**
     * @param mixed $data
     * @return boolean
     */
    public function isSatisfied($data);
}

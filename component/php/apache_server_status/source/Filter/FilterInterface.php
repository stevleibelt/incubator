<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-30
 */
namespace Net\Bazzline\Component\ApacheServerStatus\Filter;

interface FilterInterface
{
    /**
     * @param string $string
     *
     * @return boolean
     */
    public function isSatisfied($string);
}
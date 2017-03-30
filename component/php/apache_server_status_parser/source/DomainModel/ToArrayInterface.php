<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-26
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\DomainModel;

interface ToArrayInterface
{
    /**
     * @return array
     */
    public function toArray();
}
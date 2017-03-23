<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatus\Service\Fetcher;

interface FetcherInterface
{
    /**
     * @return array
     */
    public function fetch();
}
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Fetcher;

interface FetcherInterface
{
    /**
     * @return array
     */
    public function fetch();
}
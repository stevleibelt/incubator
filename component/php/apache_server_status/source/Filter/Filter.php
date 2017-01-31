<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-30
 */
namespace Net\Bazzline\Component\ApacheServerStatus\Filter;

use Net\Bazzline\Component\ApacheServerStatus\Url\Url;

class Filter
{
    /** @var string */
    private $ip;

    /** @var null|string */
    private $method;

    /** @var null|int */
    private $pid;

    /** @var null|Url */
    private $url;

    public function __construct($method = null, $pid = null, $url = null)
    {
    }

    public function byPid($pid)
    {

    }

    public function byHTTPMethod($method)
    {

    }

    public function byUrl(Url $url)
    {

    }

    public function isSatisfied($string)
    {

    }
}
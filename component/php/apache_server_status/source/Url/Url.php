<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-30
 */
namespace Net\Bazzline\Component\ApacheServerStatus\Url;

class Url
{
    /** @var string */
    private $fragment;

    /** @var string */
    private $host;

    /** @var string */
    private $path;

    /** @var int */
    private $port;

    /** @var string */
    private $query;

    /**
     * Url constructor.
     *
     * @param string $host
     * @param string $path
     * @param string $query
     * @param int $port
     * @param string $fragment
     */
    public function __construct($host, $path = '', $query = '', $port = 80, $fragment = '')
    {
        $this->fragment = (string) $fragment;
        $this->host     = (string) $host;
        $this->path     = (string) $path;
        $this->port     = (int) $port;
        $this->query    = (string) $query;
    }

    /**
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return bool
     */
    public function hasFragment()
    {
        return ($this->fragment != '');
    }

    /**
     * @return bool
     */
    public function hasPath()
    {
        return ($this->path != '');
    }

    /**
     * @return bool
     */
    public function hasQuery()
    {
        return ($this->query != '');
    }
}
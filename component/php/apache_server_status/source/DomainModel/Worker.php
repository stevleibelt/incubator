<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-02
 */
namespace Net\Bazzline\Component\ApacheServerStatus\DomainModel;

class Worker
{
    /** @var string */
    private $httpMethod;

    /** @var string */
    private $ipAddress;

    /** @var int */
    private $pid;

    /** @var string */
    private $status;

    /** @var string */
    private $uriAuthority;

    /** @var string */
    private $uriPathWithQuery;

    /**
     * Worker constructor.
     *
     * @param string $httpMethod
     * @param string $ipAddress
     * @param int $pid
     * @param string $status
     * @param string $uriAuthority
     * @param string $uriPathWithQuery
     */
    public function __construct(
        $httpMethod,
        $ipAddress,
        $pid,
        $status,
        $uriAuthority,
        $uriPathWithQuery
    )
    {
        $this->httpMethod       = $httpMethod;
        $this->ipAddress        = $ipAddress;
        $this->pid              = $pid;
        $this->status           = $status;
        $this->uriAuthority     = $uriAuthority;
        $this->uriPathWithQuery = $uriPathWithQuery;
    }

    /**
     * @return string
     */
    public function httpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function ipAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @return int
     */
    public function pid()
    {
        return $this->pid;
    }

    /**
     * @return string
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function uriAuthority()
    {
        return $this->uriAuthority;
    }

    /**
     * @return string
     */
    public function uriPathWithQuery()
    {
        return $this->uriPathWithQuery;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'http_method'           => $this->httpMethod(),
            'ip_address'            => $this->ipAddress(),
            'pid'                   => $this->pid(),
            'status'                => $this->status(),
            'uri_authority'         => $this->uriAuthority(),
            'uri_path_with_query'   => $this->uriPathWithQuery()
        ];
    }
}
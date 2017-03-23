<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-02
 */
namespace Net\Bazzline\Component\ApacheServerStatus\DomainModel;

class Worker
{
    const TO_ARRAY_KEY_HTTP_METHOD          = 'http_method';
    const TO_ARRAY_KEY_IP_ADDRESS           = 'ip_address';
    const TO_ARRAY_KEY_PID                  = 'pid';
    const TO_ARRAY_KEY_STATUS               = 'status';
    const TO_ARRAY_KEY_URI_AUTHORITY        = 'uri_authority';
    const TO_ARRAY_KEY_URI_PATH_WITH_QUERY  = 'uri_path_with_query';

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
            self::TO_ARRAY_KEY_HTTP_METHOD          => $this->httpMethod(),
            self::TO_ARRAY_KEY_IP_ADDRESS           => $this->ipAddress(),
            self::TO_ARRAY_KEY_PID                  => $this->pid(),
            self::TO_ARRAY_KEY_STATUS               => $this->status(),
            self::TO_ARRAY_KEY_URI_AUTHORITY        => $this->uriAuthority(),
            self::TO_ARRAY_KEY_URI_PATH_WITH_QUERY  => $this->uriPathWithQuery()
        ];
    }
}
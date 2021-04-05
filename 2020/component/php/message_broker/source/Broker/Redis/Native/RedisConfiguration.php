<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-16
 */

namespace Net\Bazzline\Component\MessageQueue\Broker\Redis\Native;

class RedisConfiguration
{
    /** @var string */
    private $host;

    /** @var null|string */
    private $pathToTheLocalCacheFileOrNull;

    /** @var int */
    private $port;

    /** @var string */
    private $queueName;

    /** @var int */
    private $retryInterval;

    /** @var null */
    private $reserved;

    /** @var float */
    private $timeout;

    public function __construct(
        string $host,
        string $queueName,
        string $pathToTheLocalCacheFileOrNull = null,
        int $port = 6379,
        float $timeout = 0.0,
        $reserved = null,
        int $retry_interval = 0
    ) {
        $this->host                             = $host;
        $this->pathToTheLocalCacheFileOrNull    = $pathToTheLocalCacheFileOrNull;
        $this->port                             = $port;
        $this->queueName                        = $queueName;
        $this->reserved                         = $reserved;
        $this->retryInterval                    = $retry_interval;
        $this->timeout                          = $timeout;
    }



    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }



    /**
     * @return null|string
     */
    public function getPathToTheLocalCacheFileOrNull(): string
    {
        return $this->pathToTheLocalCacheFileOrNull;
    }



    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }



    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return $this->queueName;
    }



    /**
     * @return int
     */
    public function getRetryInterval(): int
    {
        return $this->retryInterval;
    }



    /**
     * @return null
     */
    public function getReserved()
    {
        return $this->reserved;
    }



    /**
     * @return float
     */
    public function getTimeout(): float
    {
        return $this->timeout;
    }



    public function hasPathToTheLocalCacheFileOrNull(): bool
    {
        return (!is_null($this->pathToTheLocalCacheFileOrNull));
    }
}

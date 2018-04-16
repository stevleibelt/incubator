<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-16
 */

namespace Net\Bazzline\Component\MessageQueue\Broker\RabbitMQ\Bunny;

class BunnyBrokerConfiguration
{
    /** @var int */
    private $chunkSize;

    /** @var bool */
    private $isDurable;

    /** @var string */
    private $queueName;



    /**
     * BunnyBrokerConfiguration constructor.
     *
     * @param int $chunkSize
     * @param bool $isDurable
     * @param string $queueName
     */
    public function __construct(
        int $chunkSize,
        bool $isDurable,
        string $queueName
    ) {
        $this->chunkSize    = $chunkSize;
        $this->isDurable    = $isDurable;
        $this->queueName    = $queueName;
    }



    /**
     * @return int
     */
    public function getChunkSize(): int
    {
        return $this->chunkSize;
    }



    /**
     * @return bool
     */
    public function isDurable(): bool
    {
        return $this->isDurable;
    }



    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return $this->queueName;
    }
}

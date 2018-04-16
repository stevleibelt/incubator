<?php

use Net\Bazzline\Component\MessageQueue\Broker\BrokerInterface;
use Net\Bazzline\Component\MessageQueue\Broker\RabbitMQ\Bunny\BunnyBroker;
use Net\Bazzline\Component\MessageQueue\Broker\RabbitMQ\Bunny\BunnyBrokerConfiguration;
use Net\Bazzline\Component\MessageQueue\Broker\Redis\Native\RedisBroker;
use Net\Bazzline\Component\MessageQueue\Broker\Redis\Native\RedisConfiguration;

/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-16
 */

class ExampleBrokerBuilder
{
    /** @var int */
    private $brokerClassName;

    /** @var bool */
    private $isDurable;

    /** @var int */
    private $chunkSize;

    /** @var string */
    private $queueName;



    /**
     * @param int $brokerClassName
     */
    public function setBrokerClassName(string $brokerClassName)
    {
        $this->brokerClassName = $brokerClassName;
    }



    /**
     * @param bool $isDurable
     */
    public function setIsDurable(bool $isDurable)
    {
        $this->isDurable = $isDurable;
    }



    /**
     * @param int $chunkSize
     */
    public function setChunkSize(int $chunkSize)
    {
        $this->chunkSize = $chunkSize;
    }



    /**
     * @param string $queueName
     */
    public function setQueueName(string $queueName)
    {
        $this->queueName = $queueName;
    }




    /**
     * @return BrokerInterface
     * @throws InvalidArgumentException
     */
    public function build(): BrokerInterface
    {
        //begin of dependencies
        $brokerClassName    = $this->brokerClassName;
        $isDurable          = $this->isDurable;
        $chunkSize          = (is_null($this->chunkSize)) ? 1 : $this->chunkSize;
        $queueName          = $this->queueName;
        //end of dependencies

        //begin of business logic
        switch ($brokerClassName) {
            case BunnyBroker::class:
                $broker = $this->buildBunnyBroker(
                    $chunkSize,
                    $isDurable,
                    $queueName
                );
                break;
            case RedisBroker::class:
                $broker = $this->buildRedisBroker(
                    $isDurable,
                    $queueName
                );
                break;
            default:
                throw new InvalidArgumentException(
                    sprintf(
                        'Provided broker class name >>%s<< is not supported',
                        $brokerClassName
                    )
                );
        }

        return $broker;
        //end of business logic
    }



    private function buildBunnyBroker(
        int $chunkSize,
        bool $isDurable,
        string $queueName
    ): BunnyBroker {
        //begin of business logic
        $client         = new \Bunny\Client(
            [
                'host'      => 'localhost',
                'vhost'     => '/',
                'user'      => 'guest',
                'password'  => 'guest'
            ]
        );
        $configuration  = new BunnyBrokerConfiguration(
            $chunkSize,
            $isDurable,
            $queueName
        );

        return new BunnyBroker(
            $client,
            $configuration
        );
        //end of business logic
    }



    private function buildRedisBroker(
        bool $isDurable,
        string $queueName
    ): RedisBroker {
        //begin of business logic
        if ($isDurable) {
            $pathToTheLocalCacheFile = tempnam('/tmp', 'redis_message_broker_cache_');
        } else {
            $pathToTheLocalCacheFile = null;
        }

        $client         = new Redis();
        $configuration  = new RedisConfiguration(
            '127.0.0.1',
            $queueName,
            $pathToTheLocalCacheFile
        );

        return new RedisBroker(
            $client,
            $configuration
        );
        //end of business logic
    }
}

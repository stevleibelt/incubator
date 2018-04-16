<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-16
 */

namespace Net\Bazzline\Component\MessageQueue\Broker\RabbitMQ\Bunny;

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
use Net\Bazzline\Component\MessageQueue\Broker\BrokerInterface;
use Net\Bazzline\Component\MessageQueue\Broker\MessageInterface;

class BunnyBroker implements BrokerInterface
{
    /** @var BunnyBrokerConfiguration */
    private $bunnyBrokerConfiguration;

    /** @var Client */
    private $bunnyClient;

    /** @var Channel */
    private $bunnyChannel;



    /**
     * BunnyBroker constructor.
     *
     * @param Client $client
     * @param BunnyBrokerConfiguration $bunnyBrokerConfiguration
     */
    public function __construct(
        Client $client,
        BunnyBrokerConfiguration $bunnyBrokerConfiguration
    ) {
        $this->bunnyBrokerConfiguration = $bunnyBrokerConfiguration;
        $this->bunnyClient              = $client;
    }



    //begin of BrokerInterface
    /**
     * @param \Net\Bazzline\Component\MessageQueue\Broker\MessageInterface|BunnyMessage $message
     */
    public function acknowledge(MessageInterface $message)
    {
        //begin of dependencies
        $channel = $this->bunnyChannel;
        //end of dependencies

        //begin of business process
        $channel->ack(
            $message->getLibraryEncapsulatedMessage()
        );
        //end of business process
    }



    /**
     * @throws \Bunny\Exception\ClientException
     * @throws \Exception
     */
    public function connect()
    {
        //begin of dependencies
        $client         = $this->bunnyClient;
        $configuration  = $this->bunnyBrokerConfiguration;
        //end of dependencies

        //begin of business process
        $client->connect();

        $chunkSize  = $configuration->getChunkSize();
        $isDurable  = $configuration->isDurable();
        $queueName  = $configuration->getQueueName();

        $this->bunnyChannel = $client->channel();

        $this->bunnyChannel->queueDeclare(
            $queueName,
            false,
            $isDurable
        );

        if ($chunkSize > 1) {
            $this->bunnyChannel->qos(
                0,
                $chunkSize
            );
        }
        //end of business process
    }



    public function disconnect()
    {
        //begin of dependencies
        $client = $this->bunnyClient;
        //end of dependencies

        //begin of business process
        $client->disconnect();
        //end of business process
    }



    /**
     * @param MessageInterface|BunnyMessage $message
     */
    public function dismiss(MessageInterface $message)
    {
        //begin of dependencies
        $channel = $this->bunnyChannel;
        //end of dependencies

        //begin of business process
        $channel->nack(
            $message->getLibraryEncapsulatedMessage()
        );
        //end of business process
    }



    /**
     * @param MessageInterface|BunnyMessage $message
     * @return bool
     */
    public function isRedelivered(MessageInterface $message): bool
    {
        return $message->getLibraryEncapsulatedMessage()->redelivered;
    }



    public function publish(string $message)
    {
        //begin of dependencies
        $channel    = $this->bunnyChannel;
        $queueName  = $this->bunnyBrokerConfiguration->getQueueName();
        //end of dependencies

        //begin of business process
        $channel->publish(
            $message,
            [],
            '',
            $queueName
        );
        //end of business process
    }



    /**
     * @param callable $callback - gets called with MessageInterface as argument
     * @throws \Bunny\Exception\ChannelException
     */
    public function subscribe(Callable $callback)
    {
        //begin of dependencies
        $channel    = $this->bunnyChannel;
        $queueName  = $this->bunnyBrokerConfiguration->getQueueName();
        //end of dependencies

        //begin of business process
        $channel->run(
            function (Message $bunnyMessage, Channel $bunnyChannel, Client $bunnyClient) use ($callback) {
                $message = new BunnyMessage($bunnyMessage);

                $callback($message);
            },
            $queueName
        );
        //end of business process
    }
    //end of BrokerInterface
}

<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-15
 */

namespace Net\Bazzline\Component\MessageQueue;

use Bunny\Channel;
use Bunny\Client;

class RabbitMQBunnyBroker implements BrokerInterface
{
    /** @var Client */
    private $bunnyClient;

    /** @var Channel */
    private $bunnyChannel;

    public function __construct(
        Client $client,
        string $name,
        bool $isDurable = false
    ) {
        $this->bunnyClient  = $client;
        $this->bunnyChannel = $client->channel();

        if ($isDurable) {
            $this->bunnyChannel->queueDeclare(
                $name
            );
        } else {
            $this->bunnyChannel->queueDeclare(
                $name,
                false,
                true
            );
        }
    }

    //begin of BrokerInterface
    public function acknowledge(MessageInterface $message): bool
    {
        return $this->bunnyChannel->ack($message);
    }

    public function dismiss(MessageInterface $message): bool
    {
        return $this->bunnyChannel->nack($message);
    }

    public function send(MessageInterface $message): bool
    {
        // TODO: Implement send() method.
    }

    public function receiveMany(Callable $function, $numberOfMessage)
    {
        // TODO: Implement receiveMany() method.
    }

    public function receiveOne(Callable $function)
    {
        // TODO: Implement receiveOne() method.
    }
    //end of BrokerInterface
}
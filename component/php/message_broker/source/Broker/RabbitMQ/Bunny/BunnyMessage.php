<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-16
 */

namespace Net\Bazzline\Component\MessageQueue\Broker\RabbitMQ\Bunny;

use Bunny\Message;
use Net\Bazzline\Component\MessageQueue\Broker\MessageInterface;

class BunnyMessage implements MessageInterface
{
    /** @var Message */
    private $bunnyMessage;

    public function __construct(
        Message $message
    ) {
        $this->bunnyMessage = $message;
    }



    //begin of MessageInterface
    /**
     * use this to get your library dependent message.
     *
     * @return null|mixed|object|Message
     */
    public function getLibraryEncapsulatedMessage()
    {
        //begin of business process
        return $this->bunnyMessage;
        //end of business process
    }



    public function toString(): string
    {
        //begin of business process
        return (string) $this->bunnyMessage->content;
        //end of business process
    }
    //end of MessageInterface
}

<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-14
 */

namespace Net\Bazzline\Component\MessageQueue;

class Producer
{
    /** @var BrokerInterface */
    private $broker;

    public function send(MessageInterface $message)
    {
        $this->broker->send($message);
    }
}
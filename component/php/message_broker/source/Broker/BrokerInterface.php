<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-14
 */

namespace Net\Bazzline\Component\MessageQueue\Broker;

use Net\Bazzline\Component\MessageQueue\Broker\MessageInterface;

interface BrokerInterface
{
    //isDurable is something you have to configure in the real implementation
    //channelName is something you have to set in the real implementation

    public function acknowledge(MessageInterface $message);

    public function connect();

    public function disconnect();

    public function dismiss(MessageInterface $message);

    public function isRedelivered(MessageInterface $message): bool;

    public function publish(string $message);

    public function subscribe(Callable $callback);
}

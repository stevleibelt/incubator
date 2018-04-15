<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-14
 */

namespace Net\Bazzline\Component\MessageQueue;

interface BrokerInterface
{
    //isDurable is something you have to configure in the real implementation
    //channelName is something you have to set in the real implementation

    public function acknowledge(MessageInterface $message): bool;

    public function dismiss(MessageInterface $message): bool;

    public function send(MessageInterface $message): bool;

    public function receiveMany(Callable $function, $numberOfMessage);

    public function receiveOne(Callable $function);
}
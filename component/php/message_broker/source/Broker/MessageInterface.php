<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-14
 */

namespace Net\Bazzline\Component\MessageQueue\Broker;

interface MessageInterface
{
    /**
     * use this to get your library dependent message.
     *
     * @return null|mixed|object
     */
    public function getLibraryEncapsulatedMessage();

    public function toString(): string;
}

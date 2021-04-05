<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-16
 */

namespace Net\Bazzline\Component\MessageQueue\Broker\Redis\Native;

use Net\Bazzline\Component\MessageQueue\Broker\MessageInterface;

class RedisMessage implements MessageInterface
{
    /** @var string */
    private $data;

    public function __construct(
        string $data
    ) {
        $this->data = $data;
    }



    //begin of MessageInterface
    /**
     * use this to get your library dependent message.
     *
     * @return null|mixed|object
     */
    public function getLibraryEncapsulatedMessage()
    {
        return null;
    }



    public function toString(): string
    {
        return $this->data;
    }
    //end of MessageInterface
}

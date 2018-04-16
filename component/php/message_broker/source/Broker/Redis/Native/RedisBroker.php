<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-16
 */

namespace Net\Bazzline\Component\MessageQueue\Broker\Redis\Native;

use Net\Bazzline\Component\MessageQueue\Broker\BrokerInterface;
use Net\Bazzline\Component\MessageQueue\Broker\MessageInterface;
use Net\Bazzline\Component\MessageQueue\Broker\Redis\Native\Cache\CacheInterface;
use Net\Bazzline\Component\MessageQueue\Broker\Redis\Native\Cache\LocalFileCache;
use Net\Bazzline\Component\MessageQueue\Broker\Redis\Native\Cache\NullCache;
use Redis;

class RedisBroker implements BrokerInterface
{
    /** @var CacheInterface */
    private $cache;

    /** @var Redis */
    private $redisClient;

    /** @var RedisConfiguration */
    private $redisConfiguration;

    public function __construct(
        Redis $client,
        RedisConfiguration $redisConfiguration
    ) {
        //begin of dependencies
        $this->redisClient          = $client;
        $this->redisConfiguration   = $redisConfiguration;

        if ($redisConfiguration->hasPathToTheLocalCacheFileOrNull()) {
            $this->cache = new LocalFileCache(
                $redisConfiguration->getPathToTheLocalCacheFileOrNull()
            );
        } else {
            $this->cache = new NullCache();
        }
        //end of dependencies
    }



    //begin of BrokerInterface
    public function acknowledge(MessageInterface $message)
    {
        //begin of dependencies
        $cache = $this->cache;
        //end of dependencies

        //begin of business process
        if ($cache->has()) {
            $cache->delete();
        }
        //end of business process
    }



    public function connect()
    {
        //begin of dependencies
        $client     = $this->redisClient;
        $connection = $this->redisConfiguration;
        //end of dependencies

        //begin of business process
        $client->connect(
            $connection->getHost(),
            $connection->getPort(),
            $connection->getTimeout(),
            $connection->getReserved(),
            $connection->getRetryInterval()
        );
        //end of business process
    }



    public function disconnect()
    {
        //begin of dependencies
        $client = $this->redisClient;
        //end of dependencies

        //begin of business process
        $client->close();
        //end of business process
    }



    public function dismiss(MessageInterface $message)
    {
        //begin of dependencies
        $cache = $this->cache;
        //end of dependencies

        //begin of business logic
        $cache->set($message->toString());
        //end of business logic
    }



    public function isRedelivered(MessageInterface $message): bool
    {
        //begin of dependencies
        $cache = $this->cache;
        //end of dependencies

        //begin of business logic
        return $cache->has();
        //end of business logic
    }



    public function publish(string $message)
    {
        //begin of dependencies
        $client     = $this->redisClient;
        $queueName  = $this->redisConfiguration->getQueueName();
        //end of dependencies

        //begin of business process
            $client->rPush(
                $queueName,
                $message
            );
        //end of business process
    }



    /**
     * @param callable $callback - gets called with MessageInterface as argument - subscribe stops if callback returns false
     */
    public function subscribe(Callable $callback)
    {
        //begin of dependencies
        $cache          = $this->cache;
        $client         = $this->redisClient;
        $configuration  = $this->redisConfiguration;
        //end of dependencies

        //begin of business process
        while (true) {
            if ($cache->has()) {
                $redisMessage = $cache->get();
            } else {
                $redisMessage = $client->blPop(
                    [
                        $configuration->getQueueName()
                    ],
                    0
                );

                $cache->set($redisMessage);
            }

            if (is_array($redisMessage)) {
                $message = new RedisMessage($redisMessage[1]);  //[0] => queue name, [1] => data

                $stopTheLoop = !($callback($message));

                if ($stopTheLoop) {
                    break;
                }

                $cache->delete();
            } else {
                sleep(1);
            }
        }
        //end of business process
    }
    //end of BrokerInterface
}

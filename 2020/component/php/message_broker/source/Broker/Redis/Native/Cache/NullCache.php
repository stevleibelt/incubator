<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-16
 */

namespace Net\Bazzline\Component\MessageQueue\Broker\Redis\Native\Cache;

class NullCache implements CacheInterface
{
    public function delete()
    {
    }

    public function get(): string
    {
        return '';
    }



    public function has(): bool
    {
        return false;
    }



    public function set($data)
    {
    }
}

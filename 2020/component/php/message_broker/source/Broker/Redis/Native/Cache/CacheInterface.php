<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-16
 */

namespace Net\Bazzline\Component\MessageQueue\Broker\Redis\Native\Cache;

interface CacheInterface
{
    public function delete();

    public function get(): string;

    public function has(): bool;

    public function set($data);
}

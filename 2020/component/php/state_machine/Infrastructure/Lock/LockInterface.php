<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-07-20
 */
namespace Net\Bazzline\StateMachine\Infrastructure\Lock;

interface LockInterface
{
    /** boolean */
    public function isLocked();

    public function lock();

    public function unlock();
}

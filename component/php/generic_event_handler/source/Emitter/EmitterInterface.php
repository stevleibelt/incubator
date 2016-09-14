<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-09-01
 */
namespace Net\Bazzline\Component\EventHandler\Emitter;

use Net\Bazzline\Component\Event\EventInterface;

interface EmitterInterface
{
    public function emit(EventInterface $event);
}

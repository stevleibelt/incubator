<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-09-01
 */
namespace Net\Bazzline\Component\EventHandler\EventListener;

use Net\Bazzline\Component\Event\EventInterface;

interface EventListenerInterface
{
    public function __invoke(EventInterface $event);
}

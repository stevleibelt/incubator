<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-09-01
 */
namespace Net\Bazzline\Component\EventHandler;

use Net\Bazzline\Component\Event\EventInterface;

interface DispatcherInterface
{
    /**
     * @param string $fullQualifiedClassName
     * @param EventListenerInterface $listener
     */
    public function attachListenerByEventClass($fullQualifiedClassName, EventListenerInterface $listener);

    /**
     * @param string $name
     * @param EventListenerInterface $listener
     */
    public function attachListenerByEventName($name, EventListenerInterface $listener);

    /**
     * @param string $fullQualifiedClassName
     * @param EventListenerInterface $listener
     */
    public function detachListenerByEventClass($fullQualifiedClassName, EventListenerInterface $listener);

    /**
     * @param string $name
     * @param EventListenerInterface $listener
     */
    public function detachListenerByEventName($name, EventListenerInterface $listener);

    /**
     * @param EventInterface $event
     */
    public function dispatch(EventInterface $event);
}

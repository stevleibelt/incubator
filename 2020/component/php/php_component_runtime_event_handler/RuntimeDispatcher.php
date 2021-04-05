<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-09-14
 */
namespace Net\Bazzline\Component\EventHandler\Dispatcher;

use Net\Bazzline\Component\Event\EventInterface;
use Net\Bazzline\Component\EventHandler\Listener\ListenerInterface;

class RuntimeDispatcher implements DispatcherInterface
{
    /** @var array */
    private $attachedListenersByEventName;

    /** @var array */
    private $attachedListenersByFullQualifiedClassNames;


    public function __construct()
    {
        $this->attachedListenersByEventName                 = array();
        $this->attachedListenersByFullQualifiedClassNames   = array();
    }

    /**
     * @param string $fullQualifiedClassName
     * @param ListenerInterface $listener
     */
    public function attachListenerByEventClass($fullQualifiedClassName, ListenerInterface $listener)
    {
        if (!isset($this->attachedListenersByFullQualifiedClassNames[$fullQualifiedClassName])) {
            $this->attachedListenersByFullQualifiedClassNames[$fullQualifiedClassName] = array($listener);
        } else {
            $this->attachedListenersByFullQualifiedClassNames[$fullQualifiedClassName][] = $listener;
        }
    }

    /**
     * @param string $name
     * @param ListenerInterface $listener
     */
    public function attachListenerByEventName($name, ListenerInterface $listener)
    {
        if (!isset($this->attachedListenersByEventName[$name])) {
            $this->attachedListenersByEventName[$name] = array($listener);
        } else {
            $this->attachedListenersByEventName[$name][] = $listener;
        }
    }

    /**
     * @param string $fullQualifiedClassName
     * @param ListenerInterface $listener
     */
    public function detachListenerByEventClass($fullQualifiedClassName, ListenerInterface $listener)
    {
        if (!isset($this->attachedListenersByFullQualifiedClassNames[$fullQualifiedClassName])) {
            foreach ($this->attachedListenersByFullQualifiedClassNames[$fullQualifiedClassName] as $index => $listener) {
                if ($listener === $listener) {
                    unset($this->attachedListenersByFullQualifiedClassNames[$fullQualifiedClassName][$index]);
                    reset($this->attachedListenersByFullQualifiedClassNames);
                    break;
                }
            }
        }
    }

    /**
     * @param string $name
     * @param ListenerInterface $listener
     */
    public function detachListenerByEventName($name, ListenerInterface $listener)
    {
        if (!isset($this->attachedListenersByEventName[$name])) {
            foreach ($this->attachedListenersByEventName[$name] as $index => $listener) {
                if ($listener === $listener) {
                    unset($this->attachedListenersByEventName[$name][$index]);
                    reset($this->attachedListenersByEventName);
                    break;
                }
            }
        }
    }

    /**
     * @param EventInterface $event
     */
    public function dispatch(EventInterface $event)
    {
        $className  = get_class($event);
        $eventName  = $event->name();

        if (isset($this->attachedListenersByEventName[$eventName])) {
            foreach ($this->attachedListenersByEventName[$eventName] as $listener) {
                $listener($event);
            }
        }

        if (isset($this->attachedListenersByFullQualifiedClassNames[$className])) {
            foreach ($this->attachedListenersByEventName[$className] as $listener) {
                $listener($event);
            }
        }
    }
}
# Generic Event Handler Component

This free as in freedom project aims to deliver a generic and clean php event handler component.

The build status of the current master branch is tracked by Travis CI:
@todo: [![Latest stable](https://img.shields.io/packagist/v/net_bazzline/php_component_event.svg)](https://packagist.org/packages/net_bazzline/php_component_event)

The scrutinizer status are:
@todo: [![code quality](https://scrutinizer-ci.com/g/bazzline/php_component_event/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_event/)

@todo: Take a look on [openhub.net](https://www.openhub.net/p/php_component_event).

# Install

## By Hand

```
mkdir -p vendor/net_bazzline/php_component_event_handler
cd vendor/net_bazzline/php_component_event_handler
git clone https://github.com/bazzline/php_component_event_handler .
```

## With [Packagist](https://packagist.org/packages/net_bazzline/php_component_event_handler)

```
composer require net_bazzline/php_component_event_handler:dev-master
```

# Core Idea

The core idea is to separate the "an event happens" from the "react on the fact an event has happened". The separation is done by describing "an event happens" with the keyword "emit" while the "react on the fact an event has happened" is described by the keyword "dispatch".

It either ends up by using a runtime implementation, a REST based, a database based or a BUS based. 

This repository only the really basics. To prevent you from installing and shipping code you are never going to use, the real implementations are done in other repositories.

# Terms

* emitter       - sends an event
* dispatcher    - notifies listener that this event has been sent
* listener      - does things when an event happens

# Features

* uses a generic event class to increase interoperability
* generic event emiter with real implementation in dedicated packages (bus, database, rest, runtime)

# Future Features

* event loop
* promises
* co-routines
* logs events in an audit.log or event.log (separate package)
* to discuss
    * priority support (49 is default, 0 is most unimportant, 99 is most important)
    * event propagation can be stopped

# Unordered Thoughts

* workflow
    * build event
    * emitter->emit(Event) (... runtime, rest based, database, bus)
        * ImmediatelyEmitter (Runtime and Bus)
        * DeferredEmitter (Rest Based and Database)
    * DispatcherInterface->dispatch(Event)

```
[...]
With Event Sourcing we also capture each event. If we are using a persistent store the events will be persisted just the same as the ship objects are. I find it useful to say that we are persisting two different things an application state and an event log.
[...]
Event Sourcing also raises some possibilities for your overall architecture, particularly if you are looking for something that is very scalable. There is a fair amount of interest in 'event-driven architecture' these days. This term covers a fair range of ideas, but most of centers around systems communicating through event messages. Such systems can operate in a very loosely coupled parallel style which provides excellent horizontal scalability and resilience to systems failure.
[...]
```
[source](http://www.martinfowler.com/eaaDev/EventSourcing.html)

# links

* http://www.martinfowler.com/eaaDev/EventSourcing.html
* http://www.martinfowler.com/eaaDev/DomainEvent.html
* http://www.martinfowler.com/eaaDev/EventCollaboration.html
* http://www.martinfowler.com/eaaDev/AgreementDispatcher.html
* http://www.martinfowler.com/eaaDev/ParallelModel.html
* http://www.martinfowler.com/eaaDev/RetroactiveEvent.html
* https://github.com/illuminate/events
* https://github.com/othercodes/rest
* https://github.com/positivezero/rest
* https://github.com/hoaproject/Event
* https://github.com/fruux/sabre-event
* https://github.com/JBZoo/Event
* https://github.com/joomla-framework/event
* https://github.com/thinframe/events

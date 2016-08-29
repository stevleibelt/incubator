# Generic Event Handler Component

This component will help you to implement a generic event handler in your application.

It either ends up by using a runtime event dispatcher, a REST based event dispatcher, a database based event dispatcher or a BUS based event dispatcher.

# features

* uses a generic event class to increase interoperability
* generic event transporter (bus, rest, runtime)
* priority support
* event propagation can be stopped
* promises
* event emitter
* event dispatcher
* event loop
* co-routines
* logs events in an audit.log or event.log

# terms

* emitter - sends an event

# Unordered Thoughts

* instead of adding the option to stop the propagation, you should implement the logic for this in a new event which triggers your real event only under special circumstances or creates an event to reject the previous changes
* because of no support for stopping the propagation, we do not need priorities while dispatching
* an event emitter is populating the event
* an event processor is dispatching the event
* workflow
    * build event
    * EmitterInterface->emit(Event)
    * ... runtime, rest based, database, bus
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

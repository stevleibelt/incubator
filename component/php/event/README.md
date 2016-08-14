# Event

* immutable object
* event contains
    * event name (string)
    * emitter (object)
    * subject - the event arguments or data (array|Collection)
    * occured at
    * processed at (or noticed at)

# terms

* emitter - sends an event

# Unorderd Thoughts

* instead of adding the option to stop the propagation, you should implement the logic for this in a new event which triggers your real event only under special circumstances or creates an event to reject the previous changes
* because of no support for stopping the propagation, we do not need priorities while dispatching
* a event processor is dispatching the event

# Quotes

```
[...] I characterize the data on a Domain Event as immutable source data that captures what the event is about and mutable processing data that records what the system does in response to it. [...]
```
[source](http://www.martinfowler.com/eaaDev/DomainEvent.html)

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
* http://www.martinfowler.com/eaaDev/

# PHP Event Component

This free as in freedom project aims to deliver a generic, clean and immutable php event component.

The build status of the current master branch is tracked by Travis CI:
@todo[![Build Status](https://travis-ci.org/bazzline/php_component_event.png?branch=master)](http://travis-ci.org/bazzline/php_component_event)
@todo[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/php_component_event.svg)](https://packagist.org/packages/net_bazzline/php_component_event)

The scrutinizer status are:
@todo[![code quality](https://scrutinizer-ci.com/g/bazzline/php_component_event/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_event/) | [![build status](https://scrutinizer-ci.com/g/bazzline/php_component_event/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_event/)

The versioneye status is:
@todo[![Dependency Status](https://www.versioneye.com/user/projects/553941560b24225ef6000002/badge.svg?style=flat)](https://www.versioneye.com/user/projects/553941560b24225ef6000002)

Take a look on [openhub.net](https://www.openhub.net/p/php_component_event).

# Install

## By Hand

```
mkdir -p vendor/net_bazzline/php_component_event
cd vendor/net_bazzline/php_component_event
git clone https://github.com/bazzline/php_component_event .
```

## With [Packagist](https://packagist.org/packages/net_bazzline/php_component_event)

```
composer require net_bazzline/php_component_event:dev-master
```

# Benefits

* immutable object
    * no propagation support out of the box
    * no intended support for changing the subject
* event contains
    * occurred at
    * name
    * source
    * subject - the event arguments or data (array|Collection)

# Terms

* occurred at   - when did the event happen
* name          - the unique identifier for this event (I prefer human readable names instead of numbers as long as possible and I want to encourage you to do the same)
* source        - a unique identifier to track down the source where the event was created
* subject       - the event arguments or data, an array or an object like a collection

# Thoughts and Hints

* if dealing with events is getting complicated, your event is doing to much and carrying to much responsibility
* you can use `$event->name()` or `$event instanceof MyEvent` to listen only to a specific 
* instead of adding the option to stop the propagation, I would like to encourage you to follow a different way
    * create a generic event which fires your real event only under special circumstances (to move the propagation logic into an event)
    * create and fire an event which rejects your previous changes
* because of the not implemented support for stopping the propagation, we do not need priorities while dispatching

# Quotes

```
I treat an event like a taken statement. Once articulated, you can not change it since it is emitited and transported in your preferred transmission medium to the receiver.
All you can to do is to add explenations or improvments to your statement. Worst but possible, if you figure out you where wrong, you have the chance to withdraw your statement. But everything you emit (or say) after your first statement is another statement (or event).
```
@todo[source](http://www.php-professional.de/)

```
[...] I characterize the data on a Domain Event as immutable source data that captures what the event is about and mutable processing data that records what the system does in response to it. [...]
```
[source](http://www.martinfowler.com/eaaDev/DomainEvent.html)



# API

@todo[API](http://www.bazzline.net/988fc4501e48d8aed30583f58a97f0d4c14ab2d3/index.html) is available at [bazzline.net](http://www.bazzline.net).

# History

* upcomming
    * @todo
* [0.0.1](https://github.com/bazzline/php_component_event/tree/0.0.1) - released at 21.08.2016

# links

* http://www.martinfowler.com/eaaDev/EventSourcing.html
* http://www.martinfowler.com/eaaDev/DomainEvent.html
* http://www.martinfowler.com/eaaDev/EventCollaboration.html
* http://www.martinfowler.com/eaaDev/AgreementDispatcher.html
* http://www.martinfowler.com/eaaDev/ParallelModel.html
* http://www.martinfowler.com/eaaDev/RetroactiveEvent.html
* http://www.martinfowler.com/eaaDev/

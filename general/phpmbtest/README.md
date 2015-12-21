# mbtest for php

This free as in freedom project delivers you [mbtest](http://www.mbtest.org) implemented in php.

# idea

* api test double framework
* one restricted endpoint to create test doubles for a test suite
* one restricted endpoint to save a test suite
* one restricted endpoint to load a test suite
* support faker or alice configuration

# names for "imposter"

* http faker
* imposter
* hustler
* swindler
* cheater
* gyp
* shuffler
* fraud
* storyteller

# terms

* imposter
    * endpoint representing a test double
* stub
    * a set of configuration used to generate a response for an imposter
    * an imposter can have zero or multiple stubs, each of which are associated with different predicates
* predicate
    * a condition that determines whether a given stub is responsible for responding
    * each stub can have zero or multiple predicates
* response
    * the configuration that generates the response for a stub
    * each stub can have zero or multiple responses
* response type
    * defines the specific type of configuration used to generate response
    * the simplest type is called *is* which allows you to define the imposters response directly
    * we also support a *proxy* response type which allows record-replay behaviour
    * *inject* response type, which allows you to script responses
    * each response has exactly one response type
* stub behaviour
    * adds additional cross-cutting behaviour to a response
    * e.g. adding latency to the response
    * or augmenting the response with more information
    * a response can have zero or more behaviours but only one of each type of behaviour

# links

* [api overview](http://www.mbtest.org/docs/api/overview)
* [getting startet](http://www.mbtest.org/docs/gettingStarted)

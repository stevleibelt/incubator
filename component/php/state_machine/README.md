# StateMachine Component for PHP

## Basic concept and terms

A [https://en.wikipedia.org/wiki/Finite-state_machine](Finite State Machine) abstracts the switching from one state to another. Furthermore, a state machine can only be in one state.
It can change a state by a triggered event or a condition.

A state is a status that is waiting to execute a transition. A switch from one state to another is called a transition.

A transition is a collection of actions executed if an event is triggered or a condition is fulfilled.

## Code Scribble

```php
class Transition
{
    public function __construct(State $fromState, State $toState, Event $event)
    {
        //...
    }

    public function start()
    {
        //...
    }

    public function isFinished()
    {
        //...
    }
}

class State
{
}
```

## Links

* https://en.wikipedia.org/wiki/Finite-state_machine
* https://en.wikipedia.org/wiki/Transition_system
* https://en.wikipedia.org/wiki/State_machine_replication
* https://github.com/willdurand/StateMachineBehavior
* https://github.com/shrink0r/workflux
* https://github.com/Daveawb/UnderStated
* https://github.com/jonblack/arduino-fsm/blob/master/Fsm.cpp
* https://github.com/titomiguelcosta/FSM
* https://github.com/rolfvreijdenberger/izzum-statemachine
* https://github.com/yohang/Finite

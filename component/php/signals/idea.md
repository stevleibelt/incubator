# Signal Component for PHP

Write a component that is oriented on shell signals and combines the ideas of the component [instruction signal](https://github.com/stevleibelt/php_component_instruction_signal), [shutdown](https://github.com/stevleibelt/php_component_shutdown) and [lock](https://github.com/stevleibelt/php_component_lock) into one component.
Furthermore, the implementation "File", "Realtime" or "Database" should be implemented as handlers since the concept itself is simple (for example putting a suffixed file into a given path).

## Signals

The signals are influenced by the posix signals. Since the web/php process world can not provide all circumstances like a system process, they are not congruent.

* abort     -   terminates process and executes clean up
* alarm     -   indicates that the available time or memory limit elapses
* continue  -   continue interrupted work
* interrupt -   pauses the process by saving existing data and status
* kill      -   terminates process without executing clean up
* lock      -   indicates that a process is already running
* quit      -   like abort but with creating a coredump
* poll      -   a asyncronus poll is made to the process
* reload    -   reload configuration files
* start     -   starts a process

## Implementation

```php
interface SignalInterface
{
    /**
     * @throws SignalException
     */
    public function acquire();

    /**
     * @throws SignalException
     */
    public function release();
}

interface AbortInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function isAborted();
}

interface AlarmInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function isAlarmed();
}

interface ContinueInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function canBeContinued();
}

interface InterruptInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function isInterrupted();
}

interface KillInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function isKilled();
}

interface LockInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function isLocked();
}

interface QuitInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function shouldBeQuitted();
}

interface PollInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function hasBeenPolled();
}

interface ReloadInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function shouldBeReloaded();
}

interface StartInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function canBeStarted();
}
```

## Links

* http://tldp.org/LDP/Bash-Beginners-Guide/html/sect_12_01.html
* http://linux.jgfs.net/man/man7/signal.7.html
* https://en.wikipedia.org/wiki/Signal_(computing)

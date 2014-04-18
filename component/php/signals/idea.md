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


# Implementation

## Interface

```php
interface SignalInterface
{
    /**
     * @throws SignalException
     */
    public function send();

    /**
     * @return boolean
     */
    public function hasBeenSent();

    /**
     * @throws SignalException
     */
    public function intercept();

    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifer);
}

interface SignalFactory
{
    /**
     * @param string $identifier
     * @return SignalInterface
     */
    public function create($identifier)
}

abstract class AbstractSignal implements SignalInterface
{
    /**
     * @var SignalInterface
     */
    protected $identifier;

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->signal->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifer)
    {
        $this->identifier = (string) $identifier;
    }
}

class FileSignal extends AbstractSignal
{
    /**
     * @throws SignalException
     */
    public function send()
    {
        if ($this->hasBeenSent()) {
            throw new SignalException($this->getIdentifier() . ' has been sent already');
        }

        touch($this->getIdentifier());
    }

    /**
     * @return boolean
     */
    public function hasBeenSent()
    {
        return (file_exists($this->getIdentifier()));
    }

    /**
     * @throws SignalException
     */
    public function intercept()
    {
        if (!$this->hasBeenSent()) {
            throw new SignalException($this->getIdentifier() . ' has not been sent');
        }

        touch($this->getIdentifier());
    }
}

class IdenfitierFactory
{
    /**
     * @return string
     */
    createAbortIdentifier()
    {
        return 'abort';
    }

    /**
     * @return string
     */
    createAlarmIdentifier()
    {
        return 'alarm';
    }

    /**
     * @return string
     */
    createInterruptIdentifier()
    {
        return 'interrupt';
    }

    /**
     * @return string
     */
    createKillIdentifier()
    {
        return 'kill';
    }

    /**
     * @return string
     */
    createLockIdentifier()
    {
        return 'lock';
    }

    /**
     * @return string
     */
    createQuitIdentifier()
    {
        return 'quit';
    }

    /**
     * @return string
     */
    createPollIdentifier()
    {
        return 'poll';
    }

    /**
     * @return string
     */
    createReloadIdentifier()
    {
        return 'reload';
    }

    /**
     * @return string
     */
    createStartIdentifier()
    {
        return 'start';
    }
}

class SignalFileFactory implements FactoryInterface
{
    /**
     * @param string $identifier
     * @return SignalInterface
     */
    public function create($identifier)
    {
        $signal = new FileSignal();
        $signal->setIdentifier($identifier);

        return $signal;
    }
}
```

or

```php
interface SignalInterface
{
    /**
     * @throws SignalException
     */
    public function send();

    /**
     * @throws SignalException
     */
    public function intercept();
}

interface AbortInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function hasBeenAborted();
}

interface AlarmInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function hasBeenAlarmed();
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
    public function hasBeenInterrupted();
}

interface KillInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function hasBeenKilled();
}

interface LockInterface extends SignalInterface
{
    /**
     * @return boolean
     */
    public function hasBeenLocked();
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
    public function shouldBeStarted();
}
```
## Runtime Implementation

```php
class RuntimeSignal implements SignalInterface
{
    /**
     * @type boolean
     */
    private $hasBeenSent;

    public function __construct()
    {
        $this->release();
    }

    /**
     * @throws SignalException
     */
    public function acquire()
    {
        if ($this->hasBeenSent) {
            throw new SignalException('signal has been sent already');
        }

        $this->hasBeenSent = true;
    }

    /**
     * @return boolean
     */
    public function hasBeenSent()
    {
        return $this->hasBeenSent;
    }

    /**
     * @throws SignalException
     */
    public function release()
    {
        $this->hasBeenSent = false;
    }

}
```

## File Implementation

```php
//@TODO
```

## Links

* http://tldp.org/LDP/Bash-Beginners-Guide/html/sect_12_01.html
* http://linux.jgfs.net/man/man7/signal.7.html
* https://en.wikipedia.org/wiki/Signal_(computing)

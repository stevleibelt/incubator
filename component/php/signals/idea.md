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
}

interface InjectAdapterInterface
{
    public function inject(AdapterInterface $adapter);
}

interface AdapterInterface extends SignalInterface 
{
    /**
     * @return string
     */
    public function getIdentifier();
}

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @param string $identifier
     */
    public function __construct($identifier)
    {
        $this->identifier = (string) $identifier;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}

class FileAdapterInterface implements AdapterInterface
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

## Links

* http://tldp.org/LDP/Bash-Beginners-Guide/html/sect_12_01.html
* http://linux.jgfs.net/man/man7/signal.7.html
* https://en.wikipedia.org/wiki/Signal_(computing)

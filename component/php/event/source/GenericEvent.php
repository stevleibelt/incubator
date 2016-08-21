<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-08-20
 */
namespace Net\Bazzline\Component\Event;

use DateTime;

class GenericEvent implements EventInterface
{
    /** @var DateTime */
    private $emittedAt;

    /** @var string */
    private $name;

    /** @var string */
    private $source;

    /** @var array|object */
    private $subject;

    /**
     * Event constructor.
     *
     * @param DateTime $emittedAt
     * @param string $name
     * @param string $source
     * @param array|object $subject
     */
    public function __construct($emittedAt, $name, $source, $subject)
    {
        $this->emittedAt    = $emittedAt;
        $this->name         = $name;
        $this->source       = $source;
        $this->subject      = $subject;
    }

    /** @return DateTime */
    public function emittedAt()
    {
        return $this->emittedAt;
    }

    /** @return string */
    public function name()
    {
        return $this->name;
    }

    /** @return string */
    public function source()
    {
        return $this->source;
    }

    /** @return array|object */
    public function subject()
    {
        return $this->subject;
    }
}
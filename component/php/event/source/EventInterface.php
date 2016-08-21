<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-08-20
 */
namespace Net\Bazzline\Component\Event;

use DateTime;

interface EventInterface
{
    /** @return DateTime */
    public function emittedAt();

    /** @return string */
    public function name();

    /** @return string */
    public function source();

    /** @return array|object */
    public function subject();
}
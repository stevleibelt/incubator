<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-07-20
 */
namespace Net\Bazzline\StateMachine\Domain\Model;

interface StateListenerInterface
{
    /**
     * @param EventInterface $event
     * @return boolean
     */
    public function isListenOne(EventInterface $event);

    public function executeTransition(EventInterface $event);

    /** @return boolean */
    public function isNotInTheTransit();

    /** @return boolean */
    public function isInTheTransit();
}

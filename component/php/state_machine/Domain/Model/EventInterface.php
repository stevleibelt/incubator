<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-07-20
 */
namespace Net\Bazzline\StateMachine\Domain\Model;

interface EventInterface
{
    /** @return null|int */
    public function getNextStateName();

    /** @return null|int */
    public function getPreviousStateName();

    /** @return boolean */
    public function hasNextStateName();

    /** @return boolean */
    public function hasPreviousStateName();

    /**
     * @param string $firstStateName
     * @return self - same class, different object since this is an immutable object
     */
    public function moveToFirstStateName($firstStateName);

    /**
     * @param string $lastStateName
     * @return self - same class, different object since this is an immutable object
     */
    public function moveToLastStateName($lastStateName);

    /**
     * @param string $nextStateName
     * @return self - same class, different object since this is an immutable object
     */
    public function moveToNextStateName($nextStateName);

    /**
     * @param string $previousStateName
     * @return self - same class, different object since this is an immutable object
     */
    public function moveToPreviousStateName($previousStateName);
}

<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-07-20
 */
namespace Net\Bazzline\StateMachine\Domain\Model;

interface EventInterface
{
    /** @return int */
    public function fromStateName();

    /** @return int */
    public function toStateName();

    /**
     * @param $fromStateName
     * @param $toStateName
     * @return self - same class, different object since this is an immutable object
     */
    public function move($fromStateName, $toStateName);

    /**
     * @param string $toStateName
     * @return self - same class, different object since this is an immutable object
     */
    public function moveForward($toStateName);

    /**
     * @param string $toStateName
     * @return self - same class, different object since this is an immutable object
     */
    public function moveBackward($toStateName);
}

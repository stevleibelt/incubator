<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-07-20
 */
namespace Net\Bazzline\StateMachine\Domain\Service;

interface FiniteStateMachineInterface
{
    /** @return boolean */
    public function currentStateIsTheFirstState();

    /** @return boolean */
    public function currentStateIsTheLastState();

    /** @return boolean */
    public function isOnTheMove();

    public function moveToTheFirstState();

    public function moveToTheLastState();

    public function moveToTheNextState();

    public function moveToThePreviousState();
}

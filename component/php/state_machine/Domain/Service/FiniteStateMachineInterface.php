<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-07-20
 */
namespace Net\Bazzline\StateMachine\Domain\Service;

interface FiniteStateMachineInterface
{
    /** @return boolean */
    public function currentStateIsFinished();

    /** @return boolean */
    public function currentStateIsTheFirstState();

    /** @return boolean */
    public function currentStateIsTheLastState();

    public function switchToTheFirstState();

    public function switchToTheLastState();

    public function switchToTheNextState();

    public function switchToThePreviousState();
}

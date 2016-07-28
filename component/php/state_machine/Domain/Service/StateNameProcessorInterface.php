<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-07-20
 */
namespace Net\Bazzline\StateMachine\Domain\Service;

interface StateNameProcessorInterface
{
    /** @return string */
    public function getCurrentStateName();

    public function moveBackward();

    public function moveForward();

    public function moveToTheBeginning();

    public function moveToTheEnd();

    /** @return bool */
    public function weCanMoveBackward();

    /** @return bool */
    public function weCanMoveForward();
}

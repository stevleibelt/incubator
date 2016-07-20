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

    public function moveToTheInitialStateName();

    public function moveToTheNextStateName();

    public function moveToThePreviousStateName();

    /** @return bool */
    public function weCanGoToTheNextStateName();

    /** @return bool */
    public function weCanGoToThePreviousStateName();
}

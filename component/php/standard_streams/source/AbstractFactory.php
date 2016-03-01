<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-03-01
 */
namespace Net\Bazzline\Component\Cli\StandardStreams;

use Net\Bazzline\Component\Cli\StandardStreams\Read\Input;
use Net\Bazzline\Component\Cli\StandardStreams\Write\Error;
use Net\Bazzline\Component\Cli\StandardStreams\Write\Output;

abstract class AbstractFactory
{
    /**
     * @return mixed
     */
    abstract public function createNewInstance();

    /**
     * @return Error
     */
    protected function createNewErrorInstance()
    {
        return new Error();
    }

    /**
     * @return Input
     */
    protected function createNewInputInstance()
    {
        return new Input();
    }

    /**
     * @return Output
     */
    protected function createNewOutputInstance()
    {
        return new Output();
    }
}

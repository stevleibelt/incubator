<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-02-29
 */
namespace Net\Bazzline\Component\Cli\StandardStreams;

use Net\Bazzline\Component\Cli\StandardStreams\Read\Input;
use Net\Bazzline\Component\Cli\StandardStreams\Write\Error;
use Net\Bazzline\Component\Cli\StandardStreams\Write\Output;

class StandardStreamInstancePool
{
    /** @var Error */
    private $error;

    /** @var Input */
    private $input;

    /** @var Output */
    private $output;

    public function __construct(Error $error, Input $input, Output $output)
    {
        $this->error    = $error;
        $this->input    = $input;
        $this->output   = $output;
    }

    /**
     * @return Input
     */
    public function input()
    {
        return $this->input;
    }

    /**
     * @return Output
     */
    public function output()
    {
        return $this->output;
    }

    /**
     * @return Error
     */
    public function error()
    {
        return $this->error;
    }
}

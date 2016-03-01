<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-03-01
 */

namespace Net\Bazzline\Component\Cli\StandardStreams;

use Net\Bazzline\Component\Cli\StandardStreams\Read\Input;
use Net\Bazzline\Component\Cli\StandardStreams\Write\Error;
use Net\Bazzline\Component\Cli\StandardStreams\Write\Output;

class InputOutput
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
     * @return string
     */
    public function readFromTheInput()
    {
        return $this->input->read();
    }

    /**
     * @param string $string
     * @param boolean $asLine
     * @return int
     */
    public function writeToTheError($string, $asLine = true)
    {
        return ($asLine)
            ? $this->error->writeLine($string)
            : $this->error->write($string);
    }

    /**
     * @param string $string
     * @param boolean $asLine
     * @return int
     */
    public function writeToTheOutput($string, $asLine = true)
    {
        return ($asLine)
            ? $this->output->writeLine($string)
            : $this->output->write($string);
    }
}

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
    public function readFromInput()
    {
        return $this->input->read();
    }

    /**
     * @param string $string
     * @return int
     */
    public function writeLineToError($string)
    {
        return $this->error->writeLine($string);
    }

    /**
     * @param string $string
     * @return int
     */
    public function writeLineToOutput($string)
    {
        return $this->output->writeLine($string);
    }

    /**
     * @param string $string
     * @return int
     */
    public function writeToError($string)
    {
        return $this->error->write($string);
    }

    /**
     * @param string $string
     * @return int
     */
    public function writeToOutput($string)
    {
        return $this->output->write($string);
    }
}

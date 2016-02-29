<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-02-29
 */
namespace Net\Bazzline\Component\CLI\StandardStreams;

class StreamCollection
{
    /** @var Error */
    private $error;

    /** @var Input */
    private $input;

    /** @var Output */
    private $output;

    public function __construct()
    {
        $this->error    = new Error();
        $this->input    = new Input();
        $this->output   = new Output();
    }

    /**
     * @return Input
     */
    public function input()
    {
        return $this->input->read();
    }

    /**
     * @param string $string
     * @param boolean $asLine
     * @return Output
     */
    public function output($string, $asLine = true)
    {
        return ($asLine)
            ? $this->output->writeLine($string)
            : $this->output->write($string);
    }

    /**
     * @param string $string
     * @param boolean $asLine
     * @return Error
     */
    public function error($string, $asLine = true)
    {
        return ($asLine)
            ? $this->error->writeLine($string)
            : $this->error->write($string);
    }
}

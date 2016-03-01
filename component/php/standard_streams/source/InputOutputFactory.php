<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-03-01
 */

namespace Net\Bazzline\Component\Cli\StandardStreams;

class InputOutputFactory extends AbstractFactory
{
    /**
     * @return InputOutput
     */
    public function createNewInstance()
    {
        $io = new InputOutput(
            $this->createNewErrorInstance(),
            $this->createNewInputInstance(),
            $this->createNewOutputInstance()
        );

        return $io;
    }
}

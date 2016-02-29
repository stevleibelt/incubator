<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-02-29
 */
namespace Net\Bazzline\Component\CLI\StandardStreams;

abstract class AbstractWriter implements WriterInterface
{
    /**
     * @param string $string
     * @return int
     */
    public function write($string)
    {
        return fwrite($this->getHandler(), $string);
    }

    /**
     * @param string $string
     * @return int
     */
    public function writeLine($string)
    {
        return $this->write($string . PHP_EOL);
    }

    /**
     * @return resource
     */
    abstract protected function getHandler();
}

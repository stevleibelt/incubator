<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-02-29
 */
namespace Net\Bazzline\Component\CLI\StandardStreams;

interface WriterInterface
{
    /**
     * @param string $string
     * @return int
     */
    public function write($string);

    /**
     * @param string $string
     * @return int
     */
    public function writeLine($string);
}

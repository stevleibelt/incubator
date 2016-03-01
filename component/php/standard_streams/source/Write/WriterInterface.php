<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-02-29
 */
namespace Net\Bazzline\Component\Cli\StandardStreams\Write;

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

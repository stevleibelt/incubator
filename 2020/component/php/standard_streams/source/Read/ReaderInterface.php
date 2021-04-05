<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-02-29
 */
namespace Net\Bazzline\Component\Cli\StandardStreams\Read;

interface ReaderInterface
{
    /**
     * @return string
     */
    public function read();
}

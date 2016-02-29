<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-02-29
 */
namespace Net\Bazzline\Component\CLI\StandardStreams;

interface ReaderInterface
{
    /**
     * @return string
     */
    public function read();
}

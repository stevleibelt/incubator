<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-02-29
 */
namespace Net\Bazzline\Component\Cli\StandardStreams\Write;

class Error extends AbstractWriter
{
    /**
     * @return resource
     */
    protected function getHandler()
    {
        return STDERR;
    }
}

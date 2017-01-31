<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-30
 */
namespace Net\Bazzline\Component\ApacheServerStatus\Parser;

abstract class AbstractParser
{
    abstract function parseToArray();

    abstract function parseToObject();
}
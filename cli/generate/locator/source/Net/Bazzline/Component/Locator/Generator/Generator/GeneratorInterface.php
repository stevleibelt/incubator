<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;
use Net\Bazzline\Component\Locator\Generator\RuntimeException;

/**
 * Interface GeneratorInterface
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
interface GeneratorInterface
{
    public function clear();

    /**
     * @throws InvalidArgumentException|RuntimeException
     */
    public function fillOut();

    /**
     * @param string $indention - @todo replace with Indention class
     * @return string
     */
    public function andConvertToString($indention = '');

    /**
     * @return string
     */
    public function __toString();
}
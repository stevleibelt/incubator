<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Interface GeneratorInterface
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
interface GeneratorInterface extends IndentionAwareInterface
{
    public function clear();

    /**
     * @throws InvalidArgumentException|RuntimeException
     * @return string
     */
    public function generate();

    /**
     * @return boolean
     */
    public function hasContent();

    /**
     * @return string
     */
    public function __toString();
}
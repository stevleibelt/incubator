<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-25 
 */

namespace Net\Bazzline\Component\Locator\Generator\Content;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;

/**
 * Interface ContentInterface
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Content
 */
interface ContentInterface
{
    /**
     * @param string|array|ContentInterface $content
     * @throws InvalidArgumentException
     */
    public function __construct($content = null);

    /**
     * @param string|array|ContentInterface $content
     * @throws InvalidArgumentException
     */
    public function add($content);

    public function clear();

    /**
     * @return bool
     */
    public function hasContent();

    /**
     * @param string $indention
     * @return string
     */
    public function andConvertToString($indention = '');

    /**
     * @return string
     */
    public function __toString();
}
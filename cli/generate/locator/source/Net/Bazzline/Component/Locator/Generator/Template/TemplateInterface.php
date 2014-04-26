<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;
use Net\Bazzline\Component\Locator\Generator\RuntimeException;

/**
 * Interface TemplateInterface
 * @package Net\Bazzline\Component\Locator\Generator\Template
 */
interface TemplateInterface
{
    public function clear();

    /**
     * @throws InvalidArgumentException|RuntimeException
     */
    public function fillOut();

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
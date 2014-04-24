<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

/**
 * Interface TemplateInterface
 * @package Net\Bazzline\Component\Locator\Generator\Template
 */
interface TemplateInterface
{
    /**
     * @throws InvalidArgumentException|RuntimeException
     */
    public function generate();

    /**
     * @return array
     */
    public function toArray();

    /**
     * @param string $prefix
     * @return string
     */
    public function toString($prefix = '');
} 
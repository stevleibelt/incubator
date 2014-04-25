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
    public function andClearProperties();

    /**
     * @throws InvalidArgumentException|RuntimeException
     */
    public function render();

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
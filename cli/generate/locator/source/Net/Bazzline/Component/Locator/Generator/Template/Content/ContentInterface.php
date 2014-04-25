<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-25 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template\Content;

/**
 * Interface ContentInterface
 * @package Net\Bazzline\Component\Locator\Generator\Template\Content
 */
interface ContentInterface
{
    public function clear();

    /**
     * @return bool
     */
    public function hasContent();

    /**
     * @param string $prefix
     * @return string
     */
    public function toString($prefix = '');
}
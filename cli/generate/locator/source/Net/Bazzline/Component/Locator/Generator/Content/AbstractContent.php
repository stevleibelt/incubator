<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-26 
 */

namespace Net\Bazzline\Component\Locator\Generator\Content;

/**
 * Class AbstractContent
 * @package Net\Bazzline\Component\Locator\Generator\Content
 */
abstract class AbstractContent implements ContentInterface
{
    public function __clone()
    {
        $this->clear();
    }

    /**
     * @param string|ContentInterface $content
     * @throws InvalidArgumentException
     */
    public function __construct($content = null)
    {
        if (!is_null($content)) {
            $this->add($content);
        }
    }
}
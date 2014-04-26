<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-26 
 */

namespace Net\Bazzline\Component\Locator\Generator\Content;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;

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
     * @param string|array|ContentInterface $content
     * @throws InvalidArgumentException
     */
    public function __construct($content = null)
    {
        if (!is_null($content)) {
            $this->add($content);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->andConvertToString('');
    }
}
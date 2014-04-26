<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Net\Bazzline\Component\Locator\Generator\Content;

use Net\Bazzline\Component\Locator\Generator\Template\InvalidArgumentException;

/**
 * Class Line
 *
 * @package Net\Bazzline\Component\Locator\Generator\Content
 */
class Line extends AbstractContent
{
    /** @var array|string[] */
    private $parts = array();

    /** @var string */
    private $separator = ' ';

    /**
     * @param string|ContentInterface $content
     * @throws InvalidArgumentException
     */
    public function add($content)
    {
        if (is_string($content)) {
            if (strlen($content) > 0) {
                $this->parts[] = $content;
            }
        } else if ($content instanceof ContentInterface) {
            if ($content->hasContent()) {
                $this->parts[] = $content->toString();
            }
        } else {
            throw new InvalidArgumentException('content has to be string or instance of ContentInterface');
        }
    }

    /**
     * @param $separator
     */
    public function setContentSeparator($separator)
    {
        $this->separator = (string) $separator;
    }

    public function clear()
    {
        $this->parts = array();
    }

    /**
     * @return bool
     */
    public function hasContent()
    {
        return (!empty($this->parts));
    }

    /**
     * @param string $indention
     * @return string
     */
    public function toString($indention = '')
    {
        return $indention . implode($this->separator, $this->parts);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString('');
    }
}
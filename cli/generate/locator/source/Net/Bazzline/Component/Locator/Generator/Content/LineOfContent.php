<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Net\Bazzline\Component\Locator\Generator\Content;

/**
 * Class LineOfContent
 *
 * @package Net\Bazzline\Component\Locator\Generator\Content
 */
class LineOfContent implements ContentInterface
{
    /** @var array|string[] */
    private $parts = array();

    /** @var string */
    private $separator = ' ';

    public function __clone()
    {
        $this->clear();
    }

    /**
     * @param string|ContentInterface $content
     * @return $this
     */
    public function add($content)
    {
        if (strlen($content) > 0) {
            if (empty($this->parts)) {
                $this->parts[] = $content;
            } else {
                $this->parts[] = $content;
            }
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
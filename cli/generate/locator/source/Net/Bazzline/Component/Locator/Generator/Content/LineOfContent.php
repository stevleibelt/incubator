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

    public function __clone()
    {
        $this->clear();
    }

    /**
     * @param string $string
     * @param string $previousWordSeparator
     * @return $this
     */
    public function add($string, $previousWordSeparator = ' ')
    {
        if (strlen($string) > 0) {
            if (empty($this->parts)) {
                $this->parts[] = $string;
            } else {
                $this->parts[] = $previousWordSeparator . $string;
            }
        }

        return $this;
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
        return implode('', $this->parts);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString(' ');
    }
}
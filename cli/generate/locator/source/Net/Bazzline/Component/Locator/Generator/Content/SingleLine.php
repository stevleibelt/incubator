<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Net\Bazzline\Component\Locator\Generator\Content;

/**
 * Class SingleLine
 *
 * @package Net\Bazzline\Component\Locator\Generator\Content
 */
class SingleLine implements ContentInterface
{
    /** @var array|string[] */
    private $words = array();

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
            if (empty($this->words)) {
                $this->words[] = $string;
            } else {
                $this->words[] = $previousWordSeparator . $string;
            }
        }

        return $this;
    }

    public function clear()
    {
        $this->words = array();
    }

    /**
     * @return bool
     */
    public function hasContent()
    {
        return (!empty($this->words));
    }

    /**
     * @param string $prefix
     * @return string
     */
    public function toString($prefix = '')
    {
        return implode('', $this->words);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString(' ');
    }
}
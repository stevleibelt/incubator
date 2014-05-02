<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Net\Bazzline\Component\Locator\Generator\Content;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;

/**
 * Class Block
 *
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Content
 */
class Block extends AbstractContent
{
    /** @var array|ContentInterface[] */
    private $contents = array();

    /**
     * @param string|array|ContentInterface $content
     * @throws InvalidArgumentException
     */
    public function add($content)
    {
        if (is_string($content)) {
            $lineOfContent = new Line($content);
            $this->contents[] = $lineOfContent;
        } else if (is_array($content)) {
            foreach ($content as $part) {
                $this->add($part);
            }
        } else if ($content instanceof ContentInterface) {
            $this->contents[] = $content;
        } else {
            throw new InvalidArgumentException('content has to be string, an array or instance of ContentInterface');
        }
    }

    public function clear()
    {
        $this->contents = array();
    }

    /**
     * @return bool
     */
    public function hasContent()
    {
        return (!empty($this->contents));
    }

    /**
     * @param string $indention
     * @return string
     */
    public function andConvertToString($indention = '')
    {
        $string = '';
        end($this->contents);
        $lastKey = key($this->contents);
        reset($this->contents);

        foreach ($this->contents as $key => $content) {
            if ($content->hasContent()) {
                if ($content instanceof Block) {
                    $string .= $content->andConvertToString(str_repeat($indention, 2));
                } else {
                    $string .= $content->andConvertToString($indention);
                }
                if ($key !== $lastKey) {
                    $string .= PHP_EOL;
                }
            }
        }

        return $string;
    }
}
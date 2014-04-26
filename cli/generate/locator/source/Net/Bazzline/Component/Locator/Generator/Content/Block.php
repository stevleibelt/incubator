<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Net\Bazzline\Component\Locator\Generator\Content;

/**
 * Class Block
 *
 * @package Net\Bazzline\Component\Locator\Generator\Content
 */
class Block extends AbstractContent
{
    /** @var array|ContentInterface[] */
    private $contents = array();

    /**
     * @param string|ContentInterface $content
     * @throws InvalidArgumentException
     */
    public function add($content)
    {
        if (is_string($content)) {
            $lineOfContent = new Line($content);
            $this->contents[] = $lineOfContent;
        } else if ($content instanceof ContentInterface) {
            $this->contents[] = $content;
        } else {
            throw new InvalidArgumentException('content has to be string or instance of ContentInterface');
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
    public function toString($indention = '')
    {
        $string = '';
        end($this->contents);
        $lastKey = key($this->contents);
        reset($this->contents);

        foreach ($this->contents as $key => $content) {
            if ($content->hasContent()) {
                if ($content instanceof Block) {
                    $string .= $content->toString(str_repeat($indention, 2));
                } else {
                    $string .= $content->toString($indention);
                }
                if ($key !== $lastKey) {
                    $string .= PHP_EOL;
                }
            }
        }

        return $string;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString('');
    }
}
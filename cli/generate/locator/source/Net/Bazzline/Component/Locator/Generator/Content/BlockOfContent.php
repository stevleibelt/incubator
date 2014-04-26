<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Net\Bazzline\Component\Locator\Generator\Content;

/**
 * Class BlockOfContent
 *
 * @package Net\Bazzline\Component\Locator\Generator\Content
 */
class BlockOfContent implements ContentInterface
{
    /** @var bool */
    private $addEmptyLineIfAddIsCalledAgain = false;

    /** @var array|ContentInterface[] */
    private $contents = array();

    public function __clone()
    {
        $this->clear();
    }

    /**
     * @param ContentInterface $content
     * @param bool $addEmptyLineIfAddIsCalledAgain
     * @return $this
     */
    public function add(ContentInterface $content, $addEmptyLineIfAddIsCalledAgain = false)
    {
        $this->contents[] = $content;
        if ($this->addEmptyLineIfAddIsCalledAgain) {
            $clonedLine = clone $content;
            //$clonedLine->clear(); //needed?
            $this->contents[] = $clonedLine;
            $this->addEmptyLineIfAddIsCalledAgain = false;
        }
        $this->addEmptyLineIfAddIsCalledAgain = (bool) $addEmptyLineIfAddIsCalledAgain;

        return $this;
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

        foreach ($this->contents as $content) {
            if ($content->hasContent()) {
                if ($content instanceof BlockOfContent) {
                    $string .= $content->toString(str_repeat($indention, 2)) . PHP_EOL;
                } else if ($content instanceof LineOfContent) {
                    $string .= $content->toString($indention) . PHP_EOL;
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
        return $this->toString(' ');
    }
}
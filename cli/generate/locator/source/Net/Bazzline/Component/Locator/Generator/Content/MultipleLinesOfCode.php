<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Net\Bazzline\Component\Locator\Generator\Content;

/**
 * Class MultipleLinesOfCode
 *
 * @package Net\Bazzline\Component\Locator\Generator\Content
 */
class MultipleLinesOfCode implements ContentInterface
{
    /** @var bool */
    private $addEmptyLineIfAddIsCalledAgain = false;

    /** @var array|SingleLine[] */
    private $linesOfCode = array();

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
        $this->linesOfCode[] = $content;
        if ($this->addEmptyLineIfAddIsCalledAgain) {
            $clonedLine = clone $content;
            //$clonedLine->clear(); //needed?
            $this->linesOfCode[] = $clonedLine;
            $this->addEmptyLineIfAddIsCalledAgain = false;
        }
        $this->addEmptyLineIfAddIsCalledAgain = (bool) $addEmptyLineIfAddIsCalledAgain;

        return $this;
    }

    public function clear()
    {
        $this->linesOfCode = array();
    }

    /**
     * @return bool
     */
    public function hasContent()
    {
        return (!empty($this->linesOfCode));
    }

    /**
     * @param string $prefix
     * @return string
     */
    public function toString($prefix = '')
    {
        $string = '';

        foreach ($this->linesOfCode as $lineOfCode) {
            if ($lineOfCode->hasContent()) {
                $string .= $lineOfCode->toString($prefix) . PHP_EOL;
            }
        }

        return $string;
    }
}
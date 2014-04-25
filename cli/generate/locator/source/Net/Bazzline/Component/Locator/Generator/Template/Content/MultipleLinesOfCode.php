<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Net\Bazzline\Component\Locator\Generator\Template\Content;

/**
 * Class MultipleLinesOfCode
 *
 * @package Net\Bazzline\Component\Locator\Generator\Template\Content
 */
class MultipleLinesOfCode implements ContentInterface
{
    /** @var bool */
    private $addEmptyLineIfAddIsCalledAgain = false;

    /** @var array|SingleLineOfCode[] */
    private $linesOfCode = array();

    public function __clone()
    {
        $this->clear();
    }

    /**
     * @param SingleLineOfCode $line
     * @param bool $addEmptyLineIfAddIsCalledAgain
     * @return $this
     */
    public function add(SingleLineOfCode $line, $addEmptyLineIfAddIsCalledAgain = false)
    {
        $this->linesOfCode[] = $line;
        if ($this->addEmptyLineIfAddIsCalledAgain) {
            $clonedLine = clone $line;
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
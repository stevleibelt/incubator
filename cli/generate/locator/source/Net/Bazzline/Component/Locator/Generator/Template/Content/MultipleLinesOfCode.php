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
    /** @var array|SingleLineOfCode[] */
    private $linesOfCode = array();

    /**
     * @param SingleLineOfCode $line
     * @return $this
     */
    public function add(SingleLineOfCode $line)
    {
        $this->linesOfCode[] = $line;

        return $this;
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
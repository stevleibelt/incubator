<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Class BlockGenerator
 *
 * @package Net\Bazzline\Component\Locator\LocatorGenerator
 */
class BlockGenerator extends AbstractContentGenerator
{
    /** @var array|BlockGenerator[]|LineGenerator[] */
    private $contents = array();

    /**
     * @param string|array|GeneratorInterface $content
     * @throws InvalidArgumentException
     */
    public function add($content)
    {
        if (is_string($content)) {
            $lineOfContent = new LineGenerator($content, $this->getIndention());
            $this->contents[] = $lineOfContent;
        } else if (is_array($content)) {
            foreach ($content as $part) {
                $this->add($part);
            }
        } else if ($content instanceof AbstractContentGenerator) {
            $content->setIndention($this->getIndention());
            $this->contents[] = $content;
        } else {
            throw new InvalidArgumentException('content has to be string, an array or instance of AbstractContentGenerator');
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
     * @throws InvalidArgumentException|RuntimeException
     * @return string
     */
    public function generate()
    {
        $string = '';
        end($this->contents);
        $lastKey = key($this->contents);
        reset($this->contents);

        foreach ($this->contents as $key => $content) {
            if ($content->hasContent()) {
                if ($content instanceof BlockGenerator) {
                    $this->getIndention()->increaseLevel();
                    $string .= $content->generate();
                    $this->getIndention()->decreaseLevel();
                } else {
                    $string .= $content->generate();
                }
                if ($key !== $lastKey) {
                    $string .= PHP_EOL;
                }
            }
        }

        return $string;
    }
}
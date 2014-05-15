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
    private $content = array();

    /**
     * @param string|array|GeneratorInterface $content
     * @throws InvalidArgumentException
     */
    public function add($content)
    {
        if (is_string($content)) {
            $lineOfContent = $this->getLineGenerator($content);
            $this->content[] = $lineOfContent;
        } else if (is_array($content)) {
            foreach ($content as $part) {
                $this->add($part);
            }
        } else if ($content instanceof AbstractContentGenerator) {
            $content->setIndention($this->getIndention());
            $this->content[] = $content;
        } else {
            throw new InvalidArgumentException('content has to be string, an array or instance of AbstractContentGenerator');
        }
    }

    /**
     * @todo why not use AbstractGenerator::clear()?
     */
    public function clear()
    {
        $this->content = array();
    }

    /**
     * @return bool
     * @todo why not use AbstractGenerator::hasContent()?
     */
    public function hasContent()
    {
        return (!empty($this->content));
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     * @return string
     */
    public function generate()
    {
        $string = '';
        $lastKey = array_pop(array_keys($this->content));

        foreach ($this->content as $key => $content) {
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

    /**
     * @return int
     */
    public function count()
    {
        return (count($this->content));
    }
}
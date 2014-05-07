<?php
/**
 * @author sleibelt
 * @since 2014-04-25
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Class LineGenerator
 *
 * @package Net\Bazzline\Component\Locator\LocatorGenerator
 */
class LineGenerator extends AbstractContentGenerator
{
    /** @var array|string[] */
    private $parts = array();

    /** @var string */
    private $separator = ' ';

    /**
     * @param string|array|GeneratorInterface[]|AbstractContentGenerator[] $content
     * @throws InvalidArgumentException
     */
    public function add($content)
    {
        if (is_string($content)) {
            $this->parts[] = $content;
        } else if (is_array($content)) {
            foreach ($content as $part) {
                $this->add($part);
            }
        } else if ($content instanceof AbstractContentGenerator) {
            $content->setIndention($this->getIndention());
            if ($content->hasContent()) {
                $this->parts[] = $content->generate();
            }
        } else {
            throw new InvalidArgumentException('content has to be string, an array or instance of AbstractContentGenerator');
        }
    }

    /**
     * @param $separator
     */
    public function setContentSeparator($separator)
    {
        $this->separator = (string) $separator;
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
     * @throws InvalidArgumentException|RuntimeException
     * @return string
     */
    public function generate()
    {
        return (implode('', $this->parts) !== '') ? $this->getIndention()->toString() . implode($this->separator, $this->parts) : '';
    }
}
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
class BlockGenerator extends AbstractContentGenerator implements LineGeneratorDependentInterface
{
    /** @var array|BlockGenerator[]|LineGenerator[] */
    private $content = array();

    /** @var LineGenerator */
    private $lineGenerator;

    /**
     * @param LineGenerator $lineGenerator
     * @param Indention $indention
     * @param null|string|array|GeneratorInterface $content
     */
    public function __construct(LineGenerator $lineGenerator, Indention $indention, $content = null)
    {
        $this->lineGenerator = $lineGenerator;
        parent::__construct($indention, $content);
    }

    /**
     * @param LineGenerator $generator
     * @return $this
     */
    public function setLineGenerator(LineGenerator $generator)
    {
        $this->lineGenerator = $generator;

        return $this;
    }

    /**
     * @param Indention $indention
     * @return $this
     */
    public function setIndention(Indention $indention)
    {
        parent::setIndention($indention);
        $this->lineGenerator->setIndention($indention);

        return $this;
    }

    /**
     * @param string|array|GeneratorInterface $content
     * @throws InvalidArgumentException
     * @todo rename to addContent
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
     * return $this
     */
    public function clear()
    {
        $this->content = array();

        return $this;
    }

    /**
     * @return bool
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

    /**
     * @param null|string $content
     * @return LineGenerator
     */
    final protected function getLineGenerator($content = null)
    {
        $line = clone $this->lineGenerator;

        if (!is_null($content)) {
            $line->add($content);
        }

        return $line;
    }
}
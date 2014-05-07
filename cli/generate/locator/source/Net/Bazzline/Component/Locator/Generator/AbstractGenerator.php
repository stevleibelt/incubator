<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Class AbstractGenerator
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 * @todo create rendering strategy to use this trigger for add blank line if content follows
 */
abstract class AbstractGenerator implements GeneratorInterface
{
    /** @var BlockGenerator */
    private $block;

    /** @var string */
    private $indention;

    /** @var array */
    private $properties = array();

    public function __construct(Indention $indention)
    {
        $this->setIndention($indention);
        $this->clear();
    }

    public function clear()
    {
        $this->properties = array();
        //@todo clone
        $this->block = $this->getBlockGenerator();
        $this->block->setIndention($this->getIndention());
    }

    /**
     * @return Indention
     */
    public function getIndention()
    {
        return $this->indention;
    }

    /**
     * @param Indention $indention
     * @return $this
     */
    public function setIndention(Indention $indention)
    {
        $this->indention = $indention;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->generate('');
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param bool $isStackable
     */
    protected function addProperty($name, $value, $isStackable = true)
    {
        $name = (string) $name;
        if ($isStackable) {
            if ((!isset($this->properties[$name]))
                || (!is_array($this->properties[$name]))) {
                $this->properties[$name] = array();
            }
            $this->properties[$name][] = $value;
        } else {
            if (!isset($this->properties[$name])) {
                $this->properties[$name] = null;
            }
            $this->properties[$name] = $value;
        }
    }

    /**
     * @param string|AbstractGenerator[] $content
     * @param bool $isIndented
     * @throws InvalidArgumentException
     */
    protected function addContent($content, $isIndented = false)
    {
        if ($isIndented) {
            if (!($content instanceof AbstractGenerator)) {
                $content = $this->getBlockGenerator($content);
            }
            $content = $content->generate();
        }
        $this->block->add($content);
    }

    /**
     * @param GeneratorInterface $generator
     * @param bool $isIndented
     */
    protected function addGeneratorAsContent(GeneratorInterface $generator, $isIndented = false)
    {
        if ($isIndented) {
            $this->getIndention()->increaseLevel();
        }
        $generator->setIndention($this->getIndention());
        $this->addContent(
            explode(
                PHP_EOL,
                $generator->generate()
            )
        );
        if ($isIndented) {
            $this->getIndention()->decreaseLevel();
        }
    }

    /**
     * @return string
     */
    protected function generateContent()
    {
        return $this->block->generate();
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return null|string|array
     */
    protected function getProperty($name, $default = null)
    {
        return (isset($this->properties[$name])) ? $this->properties[$name] : $default;
    }

    /**
     * @param null|string|LineGenerator|BlockGenerator $content
     * @return BlockGenerator
     */
    protected function getBlockGenerator($content = null)
    {
        $block = new BlockGenerator($this->getIndention(), $content);

        return $block;
    }

    /**
     * @param null|string $content
     * @return LineGenerator
     */
    protected function getLineGenerator($content = null)
    {
        $line = new LineGenerator($this->getIndention(), $content);

        return $line;
    }

    /**
     * @return array
     */
    protected function getNotPrintableTypeHints()
    {
        return array('bool', 'boolean', 'int', 'integer', 'object', 'resource', 'string');
    }
}
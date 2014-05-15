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
    /** @var boolean */
    private $canBeGenerated;

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
    final public function getIndention()
    {
        return $this->indention;
    }

    /**
     * @param Indention $indention
     * @return $this
     */
    final public function setIndention(Indention $indention)
    {
        $this->indention = $indention;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasContent()
    {
        return $this->block->hasContent();
    }

    /**
     * @return string
     */
    final public function __toString()
    {
        return $this->generate('');
    }

    /**
     * @return $this
     */
    final protected function markAsCanBeGenerated()
    {
        $this->canBeGenerated = true;

        return $this;
    }

    /**
     * @return bool
     */
    final protected function canBeGenerated()
    {
        return ($this->canBeGenerated === true);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param bool $isStackable
     */
    final protected function addProperty($name, $value, $isStackable = true)
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
        $this->markAsCanBeGenerated();
    }

    /**
     * @param string|AbstractGenerator[] $content
     * @param bool $isIndented
     * @throws InvalidArgumentException
     */
    final protected function addContent($content, $isIndented = false)
    {
        if ($isIndented) {
            $this->getIndention()->increaseLevel();
        }
        if (!($content instanceof AbstractGenerator)) {
            if (is_array($content)) {
                $content = $this->getBlockGenerator($content);
            } else {
                $content = $this->getLineGenerator($content);
            }
        }
        $content = $content->generate();
        if ($isIndented) {
            $this->getIndention()->decreaseLevel();
        }
        $this->block->add($content);
    }

    /**
     * @param GeneratorInterface $generator
     * @param bool $isIndented - needed?
     */
    final protected function addGeneratorAsContent(GeneratorInterface $generator, $isIndented = false)
    {
        $generator->setIndention($this->getIndention());
        $this->addContent(
            explode(
                PHP_EOL,
                $generator->generate()
            ),
            $isIndented
        );
    }

    /**
     * @return string
     */
    final protected function generateStringFromContent()
    {
        return $this->block->generate();
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return null|string|array
     */
    final protected function getProperty($name, $default = null)
    {
        return (isset($this->properties[$name])) ? $this->properties[$name] : $default;
    }

    /**
     * @param null|string|LineGenerator|BlockGenerator $content
     * @return BlockGenerator
     */
    final protected function getBlockGenerator($content = null)
    {
        $block = new BlockGenerator($this->getIndention(), $content);

        return $block;
    }

    /**
     * @param null|string $content
     * @return LineGenerator
     */
    final protected function getLineGenerator($content = null)
    {
        $line = new LineGenerator($this->getIndention(), $content);

        return $line;
    }

    /**
     * @return array
     */
    final protected function getNotPrintableTypeHints()
    {
        return array('bool', 'boolean', 'int', 'integer', 'object', 'resource', 'string');
    }
}
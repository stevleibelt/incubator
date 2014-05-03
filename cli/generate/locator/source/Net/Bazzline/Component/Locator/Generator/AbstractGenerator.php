<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator;

use Net\Bazzline\Component\Locator\Generator\Content\Block;
use Net\Bazzline\Component\Locator\Generator\Content\ContentInterface;
use Net\Bazzline\Component\Locator\Generator\Content\Line;

/**
 * Class AbstractGenerator
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 * @todo create rendering strategy to use this trigger for add blank line if content follows
 */
abstract class AbstractGenerator implements GeneratorInterface
{
    /** @var Block */
    private $block;

    /** @var string */
    private $indention;

    /** @var array */
    private $properties = array();

    public function __construct()
    {
        $this->clear();
    }

    public function clear()
    {
        $this->properties = array();
        $this->block = new Block();
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
     * @param string|ContentInterface $content
     * @param bool $isIndented
     * @throws InvalidArgumentException
     */
    protected function addContent($content, $isIndented = false)
    {
        if ($isIndented) {
            if (!($content instanceof ContentInterface)) {
                $content = $this->getBlock($content);
            }
            $content = $content->andConvertToString($this->indention);
        }
        $this->block->add($content);
    }

    /**
     * @param GeneratorInterface $generator
     * @param bool $isIndented
     */
    protected function addGeneratorAsContent(GeneratorInterface $generator, $isIndented = false)
    {
        $this->addContent(
            explode(
                PHP_EOL,
                $generator->generate()
            ),
            $isIndented
        );
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
     * @param null|string|Line|Block $content
     * @return Block
     */
    protected function getBlock($content = null)
    {
        return new Block($content);
    }

    /**
     * @param null|string $content
     * @return Line
     */
    protected function getLine($content = null)
    {
        return new Line($content);
    }

    /**
     * @return array
     */
    protected function getNotPrintableTypeHints()
    {
        return array('bool', 'boolean', 'int', 'integer', 'object', 'resource', 'string');
    }
}
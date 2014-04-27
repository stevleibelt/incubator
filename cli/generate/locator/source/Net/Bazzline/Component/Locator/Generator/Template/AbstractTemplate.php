<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;
use Net\Bazzline\Component\Locator\Generator\Content\Block;
use Net\Bazzline\Component\Locator\Generator\Content\ContentInterface;
use Net\Bazzline\Component\Locator\Generator\Content\Line;

/**
 * Class AbstractTemplate
 * @package Net\Bazzline\Component\Locator\Generator\Template
 * @todo create rendering strategy to use this trigger for add blank line if content follows
 */
abstract class AbstractTemplate implements TemplateInterface
{
    const INDENTION_FOUR_SPACES = '    ';
    const INDENTION_TAB = "\t";

    /** @var Block */
    private $block;

    /** @var string */
    private $indention;

    /** @var array */
    private $properties = array();

    public function __construct()
    {
        $this->clear();
        $this->indention = self::INDENTION_FOUR_SPACES;
    }

    public function clear()
    {
        $this->properties = array();
        $this->block = new Block();
    }

    /**
     * @return string
     */
    public function getIndention()
    {
        return $this->indention;
    }

    /**
     * @param string $indention
     */
    public function setIndention($indention)
    {
        $this->indention = (string) $indention;
    }

    /**
     * @param string $indention
     * @return string
     */
    public function andConvertToString($indention = '')
    {
        return $this->block->andConvertToString($indention);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->andConvertToString('');
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
     * @param TemplateInterface $template
     * @param bool $isIndented
     */
    protected function addTemplateAsContent(TemplateInterface $template, $isIndented = false)
    {
        $this->addContent(
            explode(
                PHP_EOL,
                $template->andConvertToString()
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
}
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
    /** @var Block */
    private $block;

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
     * @throws InvalidArgumentException
     */
    protected function addContent($content)
    {
        $this->block->add($content);
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
     * @deprecated
     * @return array
     */
    public function toArray()
    {
        $array = array();

        foreach ($this->block as $content) {
            if (is_array($content)) {
                if (!empty($content)) {
                    $array[] = $content;
                }
            } else {
                $string = (string) $content;
                if (strlen($string) > 0) {
                    $array[] = $string;
                }
            }
        }

        return $array;
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
     * @deprecated
     * @param array $array
     * @param string $prefix
     * @return string
     */
    protected function arrayToString(array $array, $prefix)
    {
        $lines = array();

        foreach ($array as $value) {
            $line = (is_array($value)) ? $this->arrayToString($value, $prefix) : (string) $value;

            if (strlen($line) > 0) {
                $lines[] = $prefix . $line;
            }
        }

        $string = implode(PHP_EOL, $lines);

        return $string;
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
     * @deprecated
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    protected function renderLine($prefix = '', $suffix = '')
    {
        return $prefix . $suffix;
    }
}
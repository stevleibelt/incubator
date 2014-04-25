<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

/**
 * Class AbstractTemplate
 * @package Net\Bazzline\Component\Locator\Generator\Template
 */
abstract class AbstractTemplate implements TemplateInterface
{
    //@todo create rendering strategy to use this trigger
    //  the rendering strategy should add empty lines when needed
    /** @var bool */
    protected $addBlankLineIfContentFollows = false;

    /** @var array */
    protected $renderedContent = array();

    /** @var array */
    private $properties = array();

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

    public function andClearProperties()
    {
        $this->properties = array();
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
     * @return array
     */
    public function toArray()
    {
        $array = array();

        foreach ($this->renderedContent as $content) {
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
     * @param string $prefix
     * @return string
     */
    public function toString($prefix = '')
    {
        if (is_array($this->renderedContent)
            && !empty($this->renderedContent)) {
            return $this->arrayToString($this->renderedContent, $prefix);
        } else {
            return '';
        }
    }

    /**
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
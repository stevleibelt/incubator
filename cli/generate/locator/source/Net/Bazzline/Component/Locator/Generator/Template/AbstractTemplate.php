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
    /** @var array */
    protected $generatedContent = array();

    /** @var array */
    protected $properties = array();

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

    protected function clearProperties()
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
        return $this->generatedContent;
    }

    /**
     * @param string $prefix
     * @return string
     */
    public function toString($prefix = '')
    {
        if (is_array($this->generatedContent)
            && !empty($this->generatedContent)) {
            return $this->arrayToString($this->generatedContent, $prefix);
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
        $string = '';

        foreach ($array as $value) {
            $line = (is_array($value)) ? $this->arrayToString($value, $prefix) : (string) $value;

            if (strlen($line) > 0) {
                $string .= $prefix . $line;
            }
        }

        return $string;
    }

    /**
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    protected function generateLine($prefix = '', $suffix = '')
    {
        return $prefix . $suffix;
    }
}
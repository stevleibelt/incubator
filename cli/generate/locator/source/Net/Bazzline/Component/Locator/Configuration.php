<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-26 
 */

namespace Net\Bazzline\Component\Locator;

/**
 * Interface Configuration
 * @package Net\Bazzline\Component\Locator\Configuration
 */
class Configuration
{
    /**
     * @var array
     */
    private $extends = array();

    /**
     * @var array
     */
    private $instances = array();

    /**
     * @var array
     */
    private $implements = array();

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var array
     */
    private $uses = array();

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFileName()
    {
        return (is_string($this->name)) ? $this->name . '.php' : null;
    }

    /**
     * @return null|string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setFilePath($path)
    {
        $this->filePath = $path;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return bool
     */
    public function hasNamespace()
    {
        return (is_string($this->namespace));
    }

    /**
     * @param string $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @param string $fullQualifiedClassName
     * @param string $alias
     * @return $this
     */
    public function addSharedInstance($fullQualifiedClassName, $alias = '')
    {
        $this->instances[] = array(
            'alias' => $alias,
            'name'  => $fullQualifiedClassName
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getInstances()
    {
        return $this->instances;
    }

    /**
     * @return boolean
     */
    public function hasSharedInstances()
    {
        return (!empty($this->instances));
    }

    /**
     * @param string $fullQualifiedClassName
     * @param string $alias
     * @return $this
     */
    public function addSingleInstance($fullQualifiedClassName, $alias = '')
    {
        $this->implements[] = array(
            'alias' => $alias,
            'name'  => $fullQualifiedClassName
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getImplements()
    {
        return $this->implements;
    }

    /**
     * @return boolean
     */
    public function hasSingleInstances()
    {
        return (!empty($this->implements));
    }
}
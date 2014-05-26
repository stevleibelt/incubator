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
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $parentClassName;

    /**
     * @var array
     */
    private $sharedInstances = array();

    /**
     * @var array
     */
    private $singleInstances = array();

    /**
     * @return null|string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setClassName($name)
    {
        $this->className = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setFileName($name)
    {
        $this->fileName = $name;

        return $this;
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
     * @return null|string
     */
    public function getParentClassName()
    {
        return $this->parentClassName;
    }

    /**
     * @return boolean
     */
    public function hasParentClassName()
    {
        return (is_string($this->parentClassName));
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setParentClassName($name)
    {
        $this->parentClassName = $name;

        return $this;
    }

    /**
     * @param string $fullQualifiedClassName
     * @param string $alias
     * @return $this
     */
    public function addSharedInstance($fullQualifiedClassName, $alias = '')
    {
        $this->sharedInstances[] = array(
            'alias' => $alias,
            'name'  => $fullQualifiedClassName
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getSharedInstances()
    {
        return $this->sharedInstances;
    }

    /**
     * @return boolean
     */
    public function hasSharedInstances()
    {
        return (!empty($this->sharedInstances));
    }

    /**
     * @param string $fullQualifiedClassName
     * @param string $alias
     * @return $this
     */
    public function addSingleInstance($fullQualifiedClassName, $alias = '')
    {
        $this->singleInstances[] = array(
            'alias' => $alias,
            'name'  => $fullQualifiedClassName
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getSingleInstances()
    {
        return $this->singleInstances;
    }

    /**
     * @return boolean
     */
    public function hasSingleInstances()
    {
        return (!empty($this->singleInstances));
    }
}
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
    private $fileName;

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
        $this->fileName = $this->name . '.php';

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
        $this->filePath = (string) $path;

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
        $this->namespace = (string) $namespace;

        return $this;
    }

    /**
     * @param string $class
     * @param bool $isFactory
     * @param bool $isShared
     * @param string $alias
     * @return $this
     */
    public function addInstance($class, $isFactory, $isShared, $alias)
    {
        $this->instances[] = array(
            'alias'         => (string) $alias,
            'class'         => (string) $class,
            'is_factory'    => (bool) $isFactory,
            'is_shared'     => (bool) $isShared
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
    public function hasInstances()
    {
        return (!empty($this->instances));
    }

    /**
     * @param string $interfaceName
     * @return $this
     */
    public function addImplements($interfaceName)
    {
        $this->implements[] = $interfaceName;

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
    public function hasImplements()
    {
        return (!empty($this->implements));
    }

    /**
     * @param string $className
     * @return $this
     */
    public function addExtends($className)
    {
        $this->extends[] = (string) $className;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasExtends()
    {
        return (!empty($this->extends));
    }

    /**
     * @return array
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * @param string $fullQualifiedClassName
     * @param string $alias
     * @return $this
     */
    public function addUses($fullQualifiedClassName, $alias)
    {
        $this->uses[] = array(
            'alias' => (string) $alias,
            'name'  => (string) $fullQualifiedClassName
        );

        return $this;
    }

    /**
     * @return bool
     */
    public function hasUses()
    {
        return (!empty($this->uses));
    }

    /**
     * @return array
     */
    public function getUses()
    {
        return $this->uses;
    }


}
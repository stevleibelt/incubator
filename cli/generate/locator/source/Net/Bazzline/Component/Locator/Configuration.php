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
    private $extends;

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
    private $className;

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
        $this->className = (string) $name;
        $this->fileName = $this->className . '.php';

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
     * @param string $className
     * @param bool $isFactory
     * @param bool $isShared
     * @param string $alias
     * @return $this
     */
    public function addInstance($className, $isFactory, $isShared, $alias)
    {
        $this->instances[] = array(
            'alias'         => (string) $alias,
            'class_name'    => (string) $className,
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
    public function setExtends($className)
    {
        $this->extends = (string) $className;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasExtends()
    {
        return (is_string($this->extends));
    }

    /**
     * @return null|string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * @param string $className
     * @param string $alias
     * @return $this
     */
    public function addUses($className, $alias)
    {
        $this->uses[] = array(
            'alias'         => (string) $alias,
            'class_name'    => (string) $className
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
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-26 
 */

namespace Net\Bazzline\Component\Locator;

use Net\Bazzline\Component\Locator\Configuration\Instance;
use Net\Bazzline\Component\Locator\Configuration\Uses;

/**
 * Interface Configuration
 * @package Net\Bazzline\Component\Locator\Configuration\Assembler
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
     * @var bool
     */
    private $hasFactoryInstances = false;

    /**
     * @var bool
     */
    private $hasSharedInstances = false;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $methodPrefix;

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
     * @param string $methodPrefix
     * @return $this
     */
    public function setMethodPrefix($methodPrefix)
    {
        $this->methodPrefix = (string) $methodPrefix;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMethodPrefix()
    {
        return $this->methodPrefix;
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
        $instance = $this->getNewInstance();

        if ($isFactory) {
            $this->hasFactoryInstances = true;
        }

        if ($isShared) {
            $this->hasSharedInstances = true;
        }

        $instance->setAlias($alias);
        $instance->setClassName($className);
        $instance->setIsFactory($isFactory);
        $instance->setIsShared($isShared);

        $this->instances[] = $instance;

        return $this;
    }

    /**
     * @return array|Instance[]
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
     * @return bool
     */
    public function hasFactoryInstances()
    {
        return $this->hasFactoryInstances;
    }

    /**
     * @return bool
     */
    public function hasSharedInstances()
    {
        return $this->hasSharedInstances;
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
    public function addUses($className, $alias = '')
    {
        $uses = $this->getNewUses();

        $uses->setAlias($alias);
        $uses->setClassName($className);

        $this->uses[] = $uses;

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
     * @return array|Uses[]
     */
    public function getUses()
    {
        return $this->uses;
    }

    /**
     * @return Uses
     */
    private function getNewUses()
    {
        return new Uses();
    }

    /**
     * @return Instance
     */
    private function getNewInstance()
    {
        return new Instance();
    }
}
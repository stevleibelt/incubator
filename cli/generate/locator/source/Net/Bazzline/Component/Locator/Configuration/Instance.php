<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-07 
 */

namespace Net\Bazzline\Component\Locator\Configuration;

/**
 * Class Instance
 * @package Net\Bazzline\Component\Locator\Configuration
 */
class Instance
{
    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $className;

    /**
     * @var boolean
     */
    private $isFactory;

    /**
     * @var boolean
     */
    private $isShared;

    /**
     * @param string $alias
     */
    public function setAlias($alias)
    {
        if (!is_null($alias)) {
            $this->alias = (string) $alias;
        }
    }

    /**
     * @return null|string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return bool
     */
    public function hasAlias()
    {
        return (is_string($this->alias));
    }

    /**
     * @param string $className
     */
    public function setClassName($className)
    {
        $this->className = (string) $className;
    }

    /**
     * @return null|string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return null|boolean
     */
    public function isFactory()
    {
        return $this->isFactory;
    }

    /**
     * @param boolean $isFactory
     */
    public function setIsFactory($isFactory)
    {
        $this->isFactory = (boolean) $isFactory;
    }

    /**
     * @return null|boolean
     */
    public function isShared()
    {
        return $this->isShared;
    }

    /**
     * @param boolean $isShared
     */
    public function setIsShared($isShared)
    {
        $this->isShared = (boolean) $isShared;
    }
}
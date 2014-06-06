<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-07 
 */

namespace Net\Bazzline\Component\Locator\Configuration;

/**
 * Class Uses
 * @package Net\Bazzline\Component\Locator\Configuration
 */
class Uses
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
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = (string) $alias;
    }

    /**
     * @return null|string
     */
    public function getAlias()
    {
        return $this->alias;
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
}
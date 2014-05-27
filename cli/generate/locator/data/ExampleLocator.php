<?php
/**
 * @author Net\Bazzline\Component\Locator\Generator
 * @since 2014-05-27
 */

class ExampleLocator
{
    /**
     * @var array
     */
    private $defaultInstancePool;

    /**
     * @var array
     */
    private $factoryInstancePool;

    /**
     * @var array
     */
    private $sharedInstancePool;

    /**
     * @param $className
     * @return bool
     */
    protected function isInFactoryInstancePool($className)
    {
        return $this->isInInstancePool($className, 'factoryInstancePool');
    }

    /**
     * @param string $key
     * @param string $poolName
     * @return bool
     */
    private function isInInstancePool($key, $poolName)
    {
        return (isset($this->$poolName[$key]));
    }
}
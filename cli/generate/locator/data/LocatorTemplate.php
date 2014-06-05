<?php
/**
 * @author Net\Bazzline\Component\Locator\Generator
 * @since 2014-05-27
 */

use Net\Bazzline\Component\Locator\FactoryInterface;
use Net\Bazzline\Component\Locator\LocatorInterface;

/**
 * Class LocatorTemplate
 */
class LocatorTemplate implements LocatorInterface
{
    /**
     * @var array
     */
    private $factoryInstancePool = array();

    /**
     * @var array
     */
    private $sharedInstancePool = array();

    //---- begin of unique instances
    /**
     * @return ExampleUniqueInvokableInstance
     */
    public function getExampleUniqueInvokableInstance()
    {
        return new ExampleUniqueInvokableInstance();
    }

    /**
     * @return ExampleUniqueFactorizedInstance
     */
    public function getExampleUniqueFactorizedInstance()
    {
        return $this->fetchFromFactoryInstancePool('ExampleUniqueFactorizedInstanceFactory')->create();
    }
    //---- end of unique instances

    //---- begin of shared instances
    /**
     * @return ExampleSharedInvokableInstance
     */
    public function getExampleSharedInvokableInstance()
    {
        return $this->fetchFromSharedInstancePool('ExampleSharedInvokableInstance');
    }

    /**
     * @return ExampleSharedFactorizedInstance
     */
    public function getExampleSharedFactorizedInstance()
    {
        $className = 'ExampleSharedFactorizedInstance';

        if ($this->isNotInSharedInstancePool($className)) {
            $factoryClassName = 'ExampleSharedFactorizedInstanceFactory';
            $factory = $this->fetchFromFactoryInstancePool($factoryClassName);
            $this->addToSharedInstancePool($className, $factory->create());
        }

        return $this->fetchFromSharedInstancePool($className);
    }
    //---- end of shared instances

    //---- begin of factory instance pool
    /**
     * @param string $className
     * @param object $factory
     */
    protected function addToFactoryInstancePool($className, $factory)
    {
        $this->factoryInstancePool[$className] = $factory;
    }

    /**
     * @param string $className
     * @throws InvalidArgumentException
     * @return FactoryInterface
     */
    protected function fetchFromFactoryInstancePool($className)
    {
        if ($this->isNotInFactoryInstancePool($className)) {
            if (!class_exists($className)) {
                throw new InvalidArgumentException(
                    'factory class "' . $className . '" does not exist'
                );
            }

            /** @var FactoryInterface $factory */
            $factory = new $className();
            $factory->setLocator($this);
            $this->addToFactoryInstancePool($className, $factory);
        }

        return $this->getFromFactoryInstancePool($className);
    }

    /**
     * @param string $className
     * @return FactoryInterface
     */
    protected function getFromFactoryInstancePool($className)
    {
        return $this->factoryInstancePool[$className];
    }

    /**
     * @param $className
     * @return bool
     */
    protected function isNotInFactoryInstancePool($className)
    {
        return (!isset($this->factoryInstancePool[$className]));
    }
    //---- end of factory instance pool

    //---- begin of shared instance pool
    /**
     * @param string $className
     * @param object $instance
     * @return $this
     */
    protected function addToSharedInstancePool($className, $instance)
    {
        $this->sharedInstancePool[$className] = $instance;

        return $this;
    }

    /**
     * @param string $className
     * @throws InvalidArgumentException
     * @return mixed|stdClass
     */
    protected function fetchFromSharedInstancePool($className)
    {
        if ($this->isNotInFactoryInstancePool($className)) {
            if (!class_exists($className)) {
                throw new InvalidArgumentException(
                    'class "' . $className . '" does not exist'
                );
            }

            $instance = new $className();
            $this->addToFactoryInstancePool($className, $instance);
        }

        return $this->getFromSharedInstancePool($className);
    }

    /**
     * @param string $className
     * @return mixed|stdClass
     */
    protected function getFromSharedInstancePool($className)
    {
        return $this->sharedInstancePool[$className];
    }

    /**
     * @param $className
     * @return bool
     */
    protected function isNotInSharedInstancePool($className)
    {
        return (!isset($this->sharedInstancePool[$className]));
    }
    //---- begin of shared instance pool
}
# ZF Module for easy usage of propel 1.x

## code idea

```php
<?php
/**
* @author stev leibelt <artodeto@bazzline.net>
* @since 2014-09-02 
*/

//take a look to http://propelorm.org/Propel/documentation/02-buildtime.html#building-the-runtime-configuration
'propel_configuration' => array(
    'adapter'   => 'mysql',
    'connection' => array(
        'classname' => 'PropelPDO',
        'dns'       => 'mysql:host=localhost;port=3306;dbname=example;charset=utf8',
        'password'  => 'password',
        'user'      => 'user_name'
    ),
    'default_database' => 'example'
);

namespace LocatorGenerator\Service;

use Propel;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
* Class AbstractLocatorGeneratorFactory
* @package LocatorGenerator\Service
*/
abstract class AbstractLocatorGeneratorFactory implements FactoryInterface
{
    /**
    * Create service
    *
    * @param ServiceLocatorInterface $serviceLocator
    * @return mixed
    */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (!Propel::isInit()) {
            $configuration = $serviceLocator->get('Config');
            $locatorConfiguration = $configuration['locator_generator'];
            $propelConfiguration = $this->buildPropelConfiguration($locatorConfiguration);

            Propel::init($propelConfiguration);
        }

        return $this->createLocator($serviceLocator);
    }

    /**
    * @param ServiceLocatorInterface $serviceLocator
    * @return mixed
    */
    abstract protected function createLocator(ServiceLocatorInterface $serviceLocator);

    /**
    * @param array $configuration
    * @return array
    */
    private function buildPropelConfiguration(array $configuration)
    {
        $dataSources = array();

        foreach ($configuration['databases'] as $itemName => $itemConfiguration) {
            $dataSources[$itemName] = $itemConfiguration['propel_configuration'];
        }

        $propelConfiguration = array(
            'propel' => array(
                'datasources' => array(
                    $configuration['propel_configuration']
                ),
                'default' => $configuration['default_database']
            )
        );

        return $propelConfiguration;
    }
}
```

# links

* https://github.com/evolic/zf2-propel/tree/master/module/PropelORM
* https://github.com/haizilin/sitework-zf2-refactoring/tree/master/module/Orm/config

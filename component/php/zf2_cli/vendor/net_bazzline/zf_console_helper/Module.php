<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-09
 */

namespace ZfConsoleHelper;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

/**
 * Class Module
 * @package LocatorGenerator
 */
class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }
}

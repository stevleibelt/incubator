<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-06-04
 */

namespace ZfConsoleHelper\Controller\Console;

use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractConsoleControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return ServiceLocatorInterface
     */
    protected function transformIntoServiceManager(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ControllerManager) {
            /** @var \Zend\Mvc\Controller\ControllerManager $controllerManager */
            $controllerManager  = $serviceLocator;
            $serviceLocator     = $controllerManager->getServiceLocator();
        }

        return $serviceLocator;
    }
}
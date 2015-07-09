<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-08
 */

namespace NetBazzlineZfCliGenerator\Controller\Console;

use Net\Bazzline\Component\ProcessPipe\PipeInterface;
use Zend\ServiceManager\Exception\InvalidArgumentException;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfConsoleHelper\Controller\Console\AbstractConsoleControllerFactory;

class GenerateControllerFactory extends AbstractConsoleControllerFactory
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed|GenerateController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $controller     = new GenerateController();
        $serviceLocator = $this->transformIntoServiceManager($serviceLocator);

        /** @var array|\Zend\Config\Config $configuration */
        $configuration  = $serviceLocator->get('Config');
        $key            = 'zf_cli_generator';

        if (!isset($configuration[$key])) {
            throw new InvalidArgumentException (
                'expected configuration key "' . $key . '" not found'
            );
        }

        $configuration  = $configuration[$key];
        /** @var PipeInterface $pipe */
        $pipe           = $serviceLocator->get('NetBazzlineCliGeneratorProcessPipe');

        $controller->setConfiguration($configuration);
        $controller->setProcessPipe($pipe);

        return $controller;
    }
}
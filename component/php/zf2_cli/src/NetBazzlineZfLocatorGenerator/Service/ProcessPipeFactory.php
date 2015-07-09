<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-06-04 
 */

namespace NetBazzlineZfCliGenerator\Service;

use Net\Bazzline\Component\Locator\ProcessPipeFactory as InstanceFactory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProcessPipeFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed|\Net\Bazzline\Component\ProcessPipe\Pipe
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $factory = new InstanceFactory();

        return $factory->create();
    }
}
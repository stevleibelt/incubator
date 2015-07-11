<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-11 
 */

namespace NetBazzlineZfCliGenerator\Service;

use Net\Bazzline\Component\ProcessPipe\Pipe;
use NetBazzlineZfCliGenerator\Service\ProcessPipe\Transformer\DumpCliContent;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GenerateCliContentFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dump = new DumpCliContent();
        $dump->setTimestamp(time());

        $pipe = new Pipe(
            $dump
        );

        return $pipe;
    }
}
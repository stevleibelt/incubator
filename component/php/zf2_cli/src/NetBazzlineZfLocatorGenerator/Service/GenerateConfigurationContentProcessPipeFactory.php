<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-06-04 
 */

namespace NetBazzlineZfCliGenerator\Service;

use Net\Bazzline\Component\Command\Command;
use Net\Bazzline\Component\ProcessPipe\Pipe;
use NetBazzlineZfCliGenerator\Service\ProcessPipe\Filter\RemoveColorsAndModuleHeadlines;
use NetBazzlineZfCliGenerator\Service\ProcessPipe\Filter\RemoveFirstTwoAndLastLine;
use NetBazzlineZfCliGenerator\Service\ProcessPipe\Filter\RemoveIndexDotPhpFromLines;
use NetBazzlineZfCliGenerator\Service\ProcessPipe\Transformer\DumpConfigurationContent;
use NetBazzlineZfCliGenerator\Service\ProcessPipe\Transformer\FetchApplicationOutput;
use NetBazzlineZfCliGenerator\Service\ProcessPipe\Transformer\ParseToConfiguration;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GenerateConfigurationContentProcessPipeFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed|\Net\Bazzline\Component\ProcessPipe\Pipe
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        //--------------------------------
        //data steps
        //  fetch
        //  filter
        //  sanitize
        //  parse
        //--------------------------------
        $fetch  = new FetchApplicationOutput();
        $dump   = new DumpConfigurationContent();

        $fetch->setCommand(new Command());
        $dump->setTimestamp(time());

        $pipe = new Pipe(
            //fetch data
            $fetch,
            //filter data
            new RemoveFirstTwoAndLastLine(),
            new RemoveColorsAndModuleHeadlines(),
            //sanitize data
            new RemoveIndexDotPhpFromLines(),
            //parse data
            new ParseToConfiguration(),
            $dump
        );

        return $pipe;
    }
}
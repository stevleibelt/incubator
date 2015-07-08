<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-08
 */

namespace Test\ZfCliGenerator;

use PHPUnit_Framework_TestCase;
use Mockery;
use Zend\Stdlib\Parameters;

/**
 * Class ZfLocatorGeneratorTestCase
 * @package Test\ZfCliGenerator
 */
class ZfLocatorGeneratorTestCase extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * @return string
     */
    protected function getExampleOutput()
    {
        return <<<EOF
Zf Index - Version 1.0.0
Net\Bazzline Zf Locator Generator - Version 1.0.0

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Application
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  index.php console index [--verbose]    run index

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
ZfLocatorGenerator
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  index.php net_bazzline locator generate [<locator_name>] [--verbose]    run generation of locator depending on your configuration
  index.php net_bazzline locator list                                     list available locator with configuration path

Reason for failure: Invalid arguments or no arguments provided
EOF;
    }

    /**
     * @return Mockery\MockInterface|\Zend\Console\Adapter\AdapterInterface
     */
    protected function getMockOfConsole()
    {
        return Mockery::mock('Zend\Console\Adapter\AdapterInterface');
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\ProcessPipe\PipeInterface
     */
    protected function getMockOfProcessPipeInterface()
    {
        return Mockery::mock('Net\Bazzline\Component\ProcessPipe\PipeInterface');
    }

    /**
     * @return Mockery\MockInterface|\Zend\ServiceManager\ServiceLocatorInterface
     */
    protected function getMockOfServiceLocator()
    {
        return Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
    }

    /**
     * @param array $array
     * @return Parameters
     */
    protected function getParameters(array $array = null)
    {
        return new Parameters($array);
    }
}
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-08
 */

namespace Test\ZfCliGenerator\Controller\Console;

use Test\ZfCliGenerator\ZfCliGeneratorTestCase;
use Zend\Console\Request;
use Zend\Console\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use ZfCliGenerator\Controller\Console\GenerateController;

/**
 * Class IndexControllerTest
 * @package Test\ZfCliGenerator\Controller\Console
 */
class IndexControllerTest extends ZfCliGeneratorTestCase
{
    /** @var GenerateController */
    private $controller;

    /** @var \Mockery\MockInterface|\Zend\Console\Adapter\AdapterInterface */
    private $console;

    /** @var MvcEvent */
    private $event;

    /** @var Request */
    private $request;

    /** @var Response */
    private $response;

    /** @var RouteMatch */
    private $routeMatch;

    protected function setUp()
    {
        $this->console          = $this->getMockOfConsole();
        $this->controller       = new GenerateController();
        $this->event            = new MvcEvent();
        $this->request          = new Request();
        $this->response         = new Response();
        $this->routeMatch       = new RouteMatch(array('controller' => 'index'));

        $this->controller->setConsole($this->console);
        $this->controller->setEvent($this->event);

        $this->event->setRequest($this->request);
        $this->event->setResponse($this->response);
        $this->event->setRouteMatch($this->routeMatch);
    }

    public function testGenerateActionWithEmptyConfiguration()
    {
        $configuration  = array(
            'name_to_configuration_path' => array()
        );
        $processPipe    = $this->getMockOfProcessPipeInterface();

        $this->routeMatch->setParam('action', 'generate');
        $this->controller->setConfiguration($configuration);
        $this->controller->setProcessPipe($processPipe);

        $this->controller->dispatch($this->request);
    }

    public function testGenerateActionWithFilledConfigurationAndNoLocatorName()
    {
        $configuration  = array(
            'name_to_configuration_path' => array(
                'locator_one' => __FILE__,
                'locator_two' => __FILE__
            )
        );
        $console        = $this->console;
        $processPipe    = $this->getMockOfProcessPipeInterface();

        $console->shouldReceive('write')
            ->with('.')
            ->twice();

        $processPipe->shouldReceive('execute')
            ->twice();

        $this->controller->setConfiguration($configuration);
        $this->controller->setProcessPipe($processPipe);
        $this->routeMatch->setParam('action', 'generate');

        $this->controller->dispatch($this->request);
    }

    public function testGenerateActionWithFilledConfigurationInvalidLocatorName()
    {
        $configuration  = array(
            'name_to_configuration_path' => array(
                'locator_one' => __FILE__
            )
        );
        $console        = $this->console;
        $processPipe    = $this->getMockOfProcessPipeInterface();

        $console->shouldReceive('setColor');
        $console->shouldReceive('writeLine')
            ->with('')
            ->times(3);
        $console->shouldReceive('writeLine')
            ->with('caught exception InvalidArgumentException')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('----------------')
            ->twice();
        $console->shouldReceive('writeLine')
            ->with('with message: ')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('invalid locator name provided')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('and trace: ');
        $console->shouldReceive('writeLine')
            ->with('/^#0/');

        $this->controller->setConfiguration($configuration);
        $this->controller->setProcessPipe($processPipe);
        $this->routeMatch->setParam('action', 'generate');
        $this->request->setParams(
            $this->getParameters(
                array(
                    'locator_name' => 'valid_locator'
                )
            )
        );

        $this->controller->dispatch($this->request);
    }

    public function testGenerateActionWithFilledConfigurationValidLocatorName()
    {
        $configuration  = array(
            'name_to_configuration_path' => array(
                'valid_locator' => __FILE__
            )
        );
        $console        = $this->console;
        $processPipe    = $this->getMockOfProcessPipeInterface();

        $processPipe->shouldReceive('execute')
            ->once();

        $console->shouldReceive('write')
            ->with('.')
            ->once();

        $this->controller->setConfiguration($configuration);
        $this->controller->setProcessPipe($processPipe);
        $this->routeMatch->setParam('action', 'generate');
        $this->request->setParams(
            $this->getParameters(
                array(
                    'locator_name' => 'valid_locator'
                )
            )
        );

        $this->controller->dispatch($this->request);
    }

    public function testGenerateActionWithFilledConfigurationValidLocatorWithVerbose()
    {
        $configuration  = array(
            'name_to_configuration_path' => array(
                'valid_locator' => __FILE__
            )
        );
        $console        = $this->console;
        $processPipe    = $this->getMockOfProcessPipeInterface();

        $processPipe->shouldReceive('execute')
            ->once();

        $console->shouldReceive('writeLine')
            ->with('generating "valid_locator" by using configuration file "' . __FILE__ . '"')
            ->once();

        $this->controller->setConfiguration($configuration);
        $this->controller->setProcessPipe($processPipe);
        $this->routeMatch->setParam('action', 'generate');
        $this->request->setParams(
            $this->getParameters(
                array(
                    'locator_name' => 'valid_locator',
                    'verbose' => true
                )
            )
        );

        $this->controller->dispatch($this->request);
    }

    public function testListActionWithEmptyConfiguration()
    {
        $configuration  = array(
            'name_to_configuration_path' => array()
        );

        $this->controller->setConfiguration($configuration);
        $this->routeMatch->setParam('action', 'list');

        $this->controller->dispatch($this->request);
    }

    public function testListActionWithFilledConfiguration()
    {
        $configuration  = array(
            'name_to_configuration_path' => array(
                'locator_one' => __FILE__,
                'locator_two' => __FILE__
            )
        );
        $console        = $this->console;

        $console->shouldReceive('writeLine')
            ->with('locator: locator_one with configuration file "' . __FILE__ . '"')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('locator: locator_two with configuration file "' . __FILE__ . '"')
            ->once();

        $this->controller->setConfiguration($configuration);
        $this->routeMatch->setParam('action', 'list');

        $this->controller->dispatch($this->request);
    }
} 

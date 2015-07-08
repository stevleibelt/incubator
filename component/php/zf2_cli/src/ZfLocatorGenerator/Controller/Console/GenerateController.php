<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-08
 */

namespace ZfCliGenerator\Controller\Console;

use Exception;
use Net\Bazzline\Component\ProcessPipe\PipeInterface;
use Zend\Console\ColorInterface;
use ZfConsoleHelper\Controller\Console\AbstractConsoleController;

class GenerateController extends AbstractConsoleController
{
    /** @var array */
    private $configuration;

    /** @var PipeInterface */
    private $processPipe;

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param PipeInterface $processPipe
     */
    public function setProcessPipe(PipeInterface $processPipe)
    {
        $this->processPipe = $processPipe;
    }



    public function configurationAction()
    {
        $configuration  = $this->configuration;
        $console        = $this->getConsole();
        $processPipe    = $this->processPipe;

        try {
            $this->throwExceptionIfNotCalledInsideAnCliEnvironment();
            $configuration  = $configuration['configuration']['target'];
            $targetPathName = $configuration['path'] . DIRECTORY_SEPARATOR . $configuration['name'];

            //workflow
            //  execute php public/index.php
            //  parse output
            //  fetch important information
            //  generate configuration

            try {
                //$processPipe->execute($arguments);
                $console->writeLine('generated configuration in path: "' . $targetPathName . '"');
            } catch (Exception $exception) {
                $console->setColor(ColorInterface::LIGHT_RED);
                $console->writeLine('could not generated configuration in path: "' . $targetPathName . '"');
                $console->writeLine('error: ' . $exception->getMessage());
                $console->writeLine('trace: ' . $exception->getTraceAsString());
                $console->resetColor();
            }
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    public function cliAction()
    {
        $configuration  = $this->configuration;
        $console        = $this->getConsole();

        try {
            $this->throwExceptionIfNotCalledInsideAnCliEnvironment();

            $configuration  = $configuration['cli']['target'];
            $targetPathName = $configuration['path'] . DIRECTORY_SEPARATOR . $configuration['name'];

            //workflow
            //  generate cli file using the template
            //  this file also contains the closure used in the configuration to execute the code

            $console->writeLine('generated cli in path: "' . $targetPathName . '"');
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * @return bool
     */
    protected function beVerbose()
    {
        return $this->hasBooleanParameter('v', 'verbose');
    }
}
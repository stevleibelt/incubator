<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-08
 */

namespace NetBazzlineZfCliGenerator\Controller\Console;

use Exception;
use Net\Bazzline\Component\ProcessPipe\PipeInterface;
use Zend\Console\ColorInterface;
use ZfConsoleHelper\Controller\Console\AbstractConsoleController;

class GenerateController extends AbstractConsoleController
{
    /** @var PipeInterface */
    private $generateCli;

    /** @var PipeInterface */
    private $generateConfiguration;

    /** @var string */
    private $pathToApplication;

    /** @var string */
    private $pathToCli;

    /** @var string */
    private $pathToConfiguration;

    /**
     * @param PipeInterface $processPipe
     */
    public function setGenerateCliProcessPipe(PipeInterface $processPipe)
    {
        $this->generateCli = $processPipe;
    }

    /**
     * @param PipeInterface $processPipe
     */
    public function setGenerateConfigurationProcessPipe(PipeInterface $processPipe)
    {
        $this->generateConfiguration = $processPipe;
    }

    /**
     * @param string $pathToApplication
     */
    public function setPathToApplication($pathToApplication)
    {
        $this->pathToApplication = $pathToApplication;
    }

    /**
     * @param string $pathToCli
     */
    public function setPathToCli($pathToCli)
    {
        $this->pathToCli = $pathToCli;
    }

    /**
     * @param string $pathToConfiguration
     */
    public function setPathToConfiguration($pathToConfiguration)
    {
        $this->pathToConfiguration = $pathToConfiguration;
    }

    public function configurationAction()
    {
        //begin of dependencies
        $console                = $this->getConsole();
        $pathToApplication      = $this->pathToApplication;
        $pathToConfiguration    = $this->pathToConfiguration;
        $processPipe            = $this->generateConfiguration;
        //end of dependencies

        try {
            $this->throwExceptionIfNotCalledInsideAnCliEnvironment();

            $content                = $processPipe->execute($pathToApplication);
            $contentCouldBeWritten  = (file_put_contents($pathToConfiguration, $content) !== false);

            if ($contentCouldBeWritten) {
                $console->writeLine('generated configuration in path: "' . $pathToConfiguration . '"');
            } else {
                throw new Exception(
                    'could not write to path "' . $pathToConfiguration . '"'
                );
            }
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    public function cliAction()
    {
        //begin of dependencies
        $console                = $this->getConsole();
        $pathToApplication      = $this->pathToApplication;
        $pathToConfiguration    = $this->pathToConfiguration;
        $pathToCli              = $this->pathToCli;
        $processPipe            = $this->generateConfiguration;
        //end of dependencies

        try {
            $this->throwExceptionIfNotCalledInsideAnCliEnvironment();

            //workflow
            //  generate cli file using the template
            //  this file also contains the closure used in the configuration to execute the code
            $console->writeLine('generated cli in path: "' . $pathToCli . '"');
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
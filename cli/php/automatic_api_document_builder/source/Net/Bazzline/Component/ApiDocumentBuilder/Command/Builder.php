<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-24 
 */

namespace Net\Bazzline\Component\ApiDocumentBuilder\Command;

use Net\Bazzline\Component\ApiDocumentBuilder\Builder\Apigen;
use Net\Bazzline\Component\ApiDocumentBuilder\Builder\BuilderInterface;
use Net\Bazzline\Component\Cli\Arguments\Arguments;

class Builder
{
    /** @var Arguments */
    private $arguments;

    /** @var BuilderInterface */
    private $builder;

    /**
     * @param array $arguments
     */
    function __construct(array $arguments)
    {
        $this->arguments    = new Arguments($arguments);
        $this->builder      = new Apigen();
    }

    public function execute()
    {
        $arguments  = $this->arguments;
        $builder    = $this->builder;

        if ($arguments->hasValues()) {
            $values = $arguments->getValues();
            $pathToConfigurationFile = array_shift($values);

            //@todo implement validation
            $configuration = require_once $pathToConfigurationFile;

            $pathToData     = $configuration['paths']['data'];
            $pathToTarget   = $configuration['paths']['target'];

            foreach ($configuration['projects'] as $project) {
                $identifier = sha1($project['url']);

                $pathToProjectData = $pathToData . '/' . $identifier;
                $cwd = getcwd();

                if (!is_dir($pathToProjectData)) {
                    passthru('mkdir -p ' . $pathToProjectData);
                    passthru('cd ' . $pathToProjectData);
                    passthru('git clone ' . $project['url'] . ' .');
                } else {
                    passthru('cd ' . $pathToProjectData);
                    passthru('git pull');
                }
                passthru('cd ' . $cwd);

                $builder->setDestination($pathToProjectData);
                $builder->setSource($pathToData . '/' . $identifier . '/' . $project['source']);
                $builder->setTitle($project['title']);
                $builder->build();
            }
        } else {
            $this->printUsage();
        }
    }

    private function printUsage()
    {
        $usage = '<command> <path to configuration.php>';

        echo $usage . PHP_EOL;
    }
}
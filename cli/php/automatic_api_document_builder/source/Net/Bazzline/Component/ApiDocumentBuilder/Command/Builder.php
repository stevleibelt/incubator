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
            $projects       = array();

            foreach ($configuration['projects'] as $project) {
                $identifier = sha1($project['url']);

                $pathToProjectData  = $pathToData . '/' . $identifier;
                $cwd                = getcwd();

                if (!is_dir($pathToProjectData)) {
                    echo var_export(exec('/usr/bin/mkdir -p ' . $pathToProjectData), true) . PHP_EOL;
                    chdir($pathToProjectData);
                    echo var_export(exec('/usr/bin/git clone ' . $project['url'] . ' .'), true) . PHP_EOL;
                } else {
                    chdir($pathToProjectData);
                    echo var_export(exec('/usr/bin/git pull'), true) . PHP_EOL;
                }
                chdir($cwd);

                $builder->setDestination($pathToTarget . '/' . $identifier);
                $builder->setSource($pathToData . '/' . $identifier . '/' . $project['source']);
                $builder->setTitle($project['title']);
                $builder->build();

                $projects[] = $pathToTarget . '/' . $identifier;
            }
            //@todo build index.html
            $content = implode(PHP_EOL, $projects);
            file_put_contents($pathToTarget . '/index.html', $content);
        } else {
            $this->printUsage();
        }
    }

    private function printUsage()
    {
        $usage = '<command> <path to configuration.php>';

        echo $usage . PHP_EOL;
    }

    private function getContent()
    {
        echo '

<html>
    <head>
        <meta charset="utf-8">
        <title>code.bazzline.net</title>
    </head>
    <body>
        <h1>Available Projects</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Link to Code</th>
                <th>Link to API</th>
            </tr>
            <tr>
                <td>Code Generator Component for PHP</td>
                <td><a href="https://www.github.com/bazzline/php_component_code_generator" title="code for bazzline php component for code generator">code</a></td>
                <td><a href="php_component_code_generator/index.html" title="api for bazzline php component for code generator">api</a></td>
            </tr>
            <tr>
                <td>Locator Generator Component for PHP</td>
                <td><a href="https://www.github.com/bazzline/php_component_locator_generator" title="code for bazzline php component for locator generator">code</a></td>
                <td><a href="php_component_locator_generator/index.html" title="api for bazzline php component for locator generator">api</a></td>
            </tr>
            <tr>
                <td>Memory Limit Manager Component for PHP</td>
                <td><a href="https://www.github.com/bazzline/php_component_memory_limit_manager" title="code for bazzline php component for memory limit manager">code</a></td>
                <td><a href="php_component_memory_limit_manager/index.html" title="api for bazzline php component for memory limit manager">api</a></td>
            </tr>
            <tr>
                <td>Process Fork Manager Component for PHP</td>
                <td><a href="https://www.github.com/bazzline/php_component_process_fork_manager" title="code for bazzline php component for process fork manager">code</a></td>
                <td><a href="php_component_process_fork_manager/index.html" title="api for bazzline php component for process fork manager">api</a></td>
            </tr>
            <tr>
                <td>Time Limit Manager Component for PHP</td>
                <td><a href="https://www.github.com/bazzline/php_component_time_limit_manager" title="code for bazzline php component for time limit manager">code</a></td>
                <td><a href="php_component_time_limit_manager/index.html" title="api for bazzline php component for time limit manager">api</a></td>
            </tr>
        </table>
        <p>
            Last updated at 2014-09-23
        </p>
    </body>
</html>

        ';
    }
}
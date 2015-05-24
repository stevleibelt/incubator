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
            $configuration  = require_once $pathToConfigurationFile;

            $cwd            = getcwd();
            $pathToData     = $configuration['paths']['data'];
            $pathToTarget   = $configuration['paths']['target'];
            $projects       = array();

            echo 'updating projects ' . count($configuration['projects']) . PHP_EOL;

            foreach ($configuration['projects'] as $project) {
                $identifier         = sha1($project['url']);
                $pathToProjectData  = $pathToData . '/' . $identifier;

                if (!is_dir($pathToProjectData)) {
                    exec('/usr/bin/mkdir -p ' . $pathToProjectData);
                    chdir($pathToProjectData);
                    exec('/usr/bin/git clone ' . $project['url'] . ' .');
                } else {
                    chdir($pathToProjectData);
                    //only do update if return is not 'Already up-to-date.'
                    exec('/usr/bin/git pull');
                }
                chdir($cwd);
                exec('/usr/bin/rm -fr ' . $pathToTarget . '/' . $identifier);

                $builder->setDestination($pathToTarget . '/' . $identifier);
                $builder->setSource($pathToData . '/' . $identifier . '/' . $project['source']);
                $builder->setTitle($project['title']);
                $builder->build();

                $projects[] = array(
                    'path'  => $identifier,
                    'title' => $project['title'],
                    'url'   => $project['url']
                );
                echo '.';
            }
            echo PHP_EOL;
            echo 'generating output' . PHP_EOL;
            //@todo build index.html
            file_put_contents($pathToTarget . '/index.html', $this->getContent($projects, $configuration['title']));
            echo 'done' . PHP_EOL;
        } else {
            $this->printUsage();
        }
    }

    private function printUsage()
    {
        $usage = '<command> <path to configuration.php>';

        echo $usage . PHP_EOL;
    }

    /**
     * @param array $projects
     * @param string $title
     * @return string
     */
    private function getContent(array $projects, $title)
    {
        $content = '
<html>
    <head>
        <meta charset="utf-8">
        <title>' . $title . '</title>
    </head>
    <body>
        <h1>Available Projects</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Link to Code</th>
                <th>Link to API</th>
            </tr>';

        foreach ($projects as $project) {
            $content .= '
            <tr>
                <td>' . $project['title'] . '</td>
                <td><a href="' . $project['url'] . '" title="code for ' . $project['title'] . '">code</a></td>
                <td><a href="' . $project['path'] . '/index.html" title="api for ' . $project['title'] . '">api</a></td>
            </tr>';
        }

        $content .= '
        </table>
        <p>
            Last updated at ' . date('Y-m-d H:i:s') . '
        </p>
    </body>
</html>';

        return $content;
    }
}
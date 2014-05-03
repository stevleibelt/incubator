<?php
/**
 * @author sleibelt
 * @since 2014-04-29
 */
#!/bin/php

use Net\Bazzline\Component\Locator\Generator;

require_once __DIR__ . '/../../../../../vendor/autoload.php';

global $argc, $argv;

$isNotCalledFromCommandLineInterface = (PHP_SAPI !== 'cli');

$usageMessage = 'Usage: ' . PHP_EOL .
    basename(__FILE__) . ' <path to configuration file> <output-path>' . PHP_EOL;

if ($isNotCalledFromCommandLineInterface) {
    echo 'This script can only be called from the command line' . PHP_EOL .
        $usageMessage;
    exit(1);
}

if ($argc !== 3) {
    echo 'called with invalid number of arguments' . PHP_EOL;
    echo $usageMessage;
    exit(1);
}

$cwd = getcwd();
$outputPath = $cwd . DIRECTORY_SEPARATOR . $argv[2];
$pathToConfigurationFile = $cwd . DIRECTORY_SEPARATOR . $argv[1];

try {
    $generator = new Generator();
    $generator->setOutputPath($outputPath);
    $generator->setPathToConfigurationFile($pathToConfigurationFile);
    $generator->generate();
    echo 'locator written into "' . $outputPath . '"' . PHP_EOL;
    exit(0);
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
    exit(1);
}
<?php
#!/bin/php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-10 
 */

use Net\Bazzline\Component\Locator\Configuration;
use Net\Bazzline\Component\Locator\LocatorGeneratorFactory;

require_once __DIR__ . '/../vendor/autoload.php';

global $argc, $argv;

$isNotCalledFromCommandLineInterface = (PHP_SAPI !== 'cli');

$usageMessage = 'Usage: ' . PHP_EOL .
    basename(__FILE__) . ' <path to configuration file>' . PHP_EOL;

if ($isNotCalledFromCommandLineInterface) {
    echo 'This script can only be called from the command line' . PHP_EOL .
        $usageMessage;
    exit(1);
}

if ($argc !== 2) {
    echo 'called with invalid number of arguments' . PHP_EOL;
    echo $usageMessage;
    exit(1);
}

$cwd = getcwd();
$pathToConfigurationFile = realpath($cwd . DIRECTORY_SEPARATOR . $argv[1]);

try {
    //----begin of validation
    if (!is_file($pathToConfigurationFile)) {
        throw new Exception(
            'provided path "' . $pathToConfigurationFile . '" is not a file'
        );
    }

    if (!is_readable($pathToConfigurationFile)) {
        throw new Exception(
            'file "' . $pathToConfigurationFile . '" is not readable'
        );
    }

    $data = require_once $pathToConfigurationFile;

    if (!isset($data['assembler'])) {
        throw new Exception(
            'data array must contain content for key "assembler"'
        );
    }

    if (!class_exists($data['assembler'])) {
        throw new Exception(
            'provided assembler "' . $data['assembler'] . '" does not exist'
        );
    }

    if (!isset($data['file_exists_strategy'])) {
        throw new Exception(
            'data array must contain content for key "file_exists_strategy"'
        );
    }

    if (!class_exists($data['file_exists_strategy'])) {
        throw new Exception(
            'provided file exists strategy "' . $data['file_exists_strategy'] . '" does not exist'
        );
    }
    //----end of validation
    /**
     * @var \Net\Bazzline\Component\Locator\Configuration\Assembler\AssemblerInterface $assembler
     * @var \Net\Bazzline\Component\Locator\FileExistsStrategy\FileExistsStrategyInterface $fileExistsStrategy
     */
    $assembler = new $data['assembler']();
    $configuration = new Configuration();
    $factory = new LocatorGeneratorFactory();
    $fileExistsStrategy = new $data['file_exists_strategy']();
    $generator = $factory->create();

    $assembler->setConfiguration($configuration);
    $assembler->assemble($data);

    $generator->setConfiguration($assembler->getConfiguration());
    $generator->setFileExistsStrategy($fileExistsStrategy);
    $generator->generate();

    echo 'locator "' . $configuration->getFileName() . '" written into "' . realpath($configuration->getFilePath()) . '"' . PHP_EOL;
    exit(0);
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
    exit(1);
}
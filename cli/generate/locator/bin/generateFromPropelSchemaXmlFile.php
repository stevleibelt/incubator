<?php
#!/bin/php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-07 
 */

use Net\Bazzline\Component\Locator\LocatorGeneratorFactory;
use Net\Bazzline\Component\Locator\Configuration;
use Net\Bazzline\Component\Locator\Configuration\Assembler\FromPropelSchemaXmlAssembler;
use Net\Bazzline\Component\Locator\FileExistsStrategy\SuffixWithCurrentTimestampStrategy;

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

    $assembler = new FromPropelSchemaXmlAssembler();
    $configuration = new Configuration();
    $factory = new LocatorGeneratorFactory();
    $fileExistsStrategy = new SuffixWithCurrentTimestampStrategy();
    $generator = $factory->create();

    $assembler->setConfiguration($configuration);
    $assembler->assemble($data);

    $fileExistsStrategy->setCurrentTimeStamp(time());

    $generator->setConfiguration($assembler->getConfiguration());
    $generator->setFileExistsStrategy($fileExistsStrategy);
    $generator->generate();

    echo 'locator "' . $configuration->getFileName() . '" written into "' . realpath($configuration->getFilePath()) . '"' . PHP_EOL;
    exit(0);
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
    exit(1);
}
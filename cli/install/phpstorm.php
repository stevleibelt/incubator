<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-22 
 */

$isNotCalledFromCommandLineInterface = (PHP_SAPI !== 'cli');

$usage = 'Usage:' . PHP_EOL .
    basename(__FILE__) . ' <path to new version> [<group name>]';

$pathToCurrentInstallation = '/usr/share/phpstorm';
$pathToCurrentInstallation = '/tmp/phpstorm';

try {
    if ($isNotCalledFromCommandLineInterface) {
        throw new RuntimeException(
            'command line script only'
        );
    }

    $currentWorkingDirectory = getcwd();
    $relativeScriptFilePath = array_shift($argv);
    $pathToNewVersion = array_shift($argv);
    $groupName = array_shift($argv);

    if (is_null($pathToNewVersion)) {
        throw new InvalidArgumentException(
            'path to new version is mandatory'
        );
    }

    $newVersionFileName = basename($pathToNewVersion);
    $start = 9; //strlen('PhpStorm-');
    $end = 7;   //strlen('.tar.gz');

    $version = substr($newVersionFileName, $start, -$end);

    if (is_dir($pathToCurrentInstallation)) {
        $currentDate = date('Y_m_d');
        $backupName = 'phpstorm_' . $currentDate . '.tar.gz';

        echo 'creating backup named "' . $backupName . '"' . PHP_EOL;

        $lines = array();
        $return = null;
        $command = 'tar --ignore-failed-read -zcf ' . $backupName . ' ' . $pathToCurrentInstallation;
        exec($command, $lines, $return);

        if ($return > 0) {
            throw new RuntimeException(
                'following command created an error: "' . $command . '"' . PHP_EOL .
                'return: "' . $return . '"'
            );
        }

        echo 'removing old installation' . PHP_EOL;

        $lines = array();
        $return = null;
        $command = 'rm -fr ' . $pathToCurrentInstallation;
        exec($command, $lines, $return);

        if ($return > 0) {
            throw new RuntimeException(
                'following command created an error: "' . $command . '"' . PHP_EOL .
                'return: "' . $return . '"'
            );
        }
    }

    echo 'installing version ' . $version . PHP_EOL;

    $lines = array();
    $return = null;
    $command = 'mkdir ' . $pathToCurrentInstallation;
    exec($command, $lines, $return);

    if ($return > 0) {
        throw new RuntimeException(
            'following command created an error: "' . $command . '"' . PHP_EOL .
            'return: "' . $return . '"'
        );
    }

    $lines = array();
    $return = null;
    $command = 'tar -ztf ' . $pathToNewVersion;
    exec($command, $lines, $return);

    if ($return > 0) {
        throw new RuntimeException(
            'following command created an error: "' . $command . '"' . PHP_EOL .
            'return: "' . $return . '"'
        );
    }

    $unpackedDirectoryName = array_shift(explode('/', $lines[0]));
//@todo - steps
    //backup existing version
    //unpack new version
    //copy new version nearby the existing version
    //create softlink
//@todo move unpacked director name into fitting path
echo $unpackedDirectoryName . PHP_EOL;

    $lines = array();
    $return = null;
    $command = 'tar -zxf ' . $pathToNewVersion . ' -C ' . $pathToCurrentInstallation;
    exec($command, $lines, $return);

    if ($return > 0) {
        throw new RuntimeException(
            'following command created an error: "' . $command . '"' . PHP_EOL .
            'return: "' . $return . '"'
        );
    }

    if (!is_null($groupName)) {
        echo 'updating group to ' . $groupName . PHP_EOL;

        $lines = array();
        $return = null;
        $command = 'sudo chgrp -R ' . $groupName . ' ' . $pathToCurrentInstallation;
        exec($command, $lines, $return);

        if ($return > 0) {
            throw new RuntimeException(
                'following command created an error: "' . $command . '"' . PHP_EOL .
                'return: "' . $return . '"'
            );
        }

        echo 'setting permissions' . PHP_EOL;

        $lines = array();
        $return = null;
        $command = 'sudo chmod -R 770 ' . $pathToCurrentInstallation;
        exec($command, $lines, $return);

        if ($return > 0) {
            throw new RuntimeException(
                'following command created an error: "' . $command . '"' . PHP_EOL .
                'return: "' . $return . '"'
            );
        }
    }
} catch (Exception $exception) {
    echo 'Error' . PHP_EOL;
    echo '----------------' . PHP_EOL;
    echo $exception->getMessage() . PHP_EOL;
    echo '--------' . PHP_EOL;
    echo $exception->getTraceAsString() . PHP_EOL;
    echo PHP_EOL;
    echo $usage . PHP_EOL;
    echo '----------------' . PHP_EOL;
}

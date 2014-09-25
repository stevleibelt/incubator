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

/**
 * @param $command
 * @return array
 */
function executeCommand($command)
{
    $lines = array();
    $return = null;
    exec($command, $lines, $return);

    if ($return > 0) {
        throw new RuntimeException(
            'following command created an error: "' . $command . '"' . PHP_EOL .
            'return: "' . $return . '"'
        );
    }

    return $lines;
}

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

        $command = 'tar --ignore-failed-read -zcf ' . $backupName . ' ' . $pathToCurrentInstallation;
        executeCommand($command);

        echo 'removing old installation' . PHP_EOL;

        $command = 'rm -fr ' . $pathToCurrentInstallation;
        executeCommand($command);
    }

    echo 'installing version ' . $version . PHP_EOL;

    $command = 'mkdir ' . $pathToCurrentInstallation;
    executeCommand($command);

    $command = 'tar -ztf ' . $pathToNewVersion;
    executeCommand($command);

    $unpackedDirectoryName = array_shift(explode('/', $lines[0]));
//@todo - steps
    //backup existing version
    //unpack new version
    //copy new version nearby the existing version
    //create softlink
//@todo move unpacked director name into fitting path
echo $unpackedDirectoryName . PHP_EOL;

    $command = 'tar -zxf ' . $pathToNewVersion . ' -C ' . $pathToCurrentInstallation;
    executeCommand($command);

    if (!is_null($groupName)) {
        echo 'updating group to ' . $groupName . PHP_EOL;

        $command = 'sudo chgrp -R ' . $groupName . ' ' . $pathToCurrentInstallation;
        executeCommand($command);

        echo 'setting permissions' . PHP_EOL;

        $command = 'sudo chmod -R 770 ' . $pathToCurrentInstallation;
        executeCommand($command);
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

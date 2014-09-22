<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-22 
 */

$isNotCalledFromCommandLineInterface = (PHP_SAPI !== 'cli');

$usage = 'Usage:' . PHP_EOL .
    basename(__FILE__) . ' <path to new version> [<group name>]';

$pathToCurrentInstallation = '/usr/share/phpstorm';

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

    echo $currentWorkingDirectory . PHP_EOL;
    echo $relativeScriptFilePath . PHP_EOL;
    echo var_export($pathToNewVersion, true) . PHP_EOL;
    echo $groupName . PHP_EOL;

    if (is_null($pathToNewVersion)) {
        throw new InvalidArgumentException(
            'path to new version ins mandatory'
        );
    }

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

    echo 'installing version' . PHP_EOL;

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
    $command = 'tar -zxf ' . $pathToNewVersion . ' -C ' . $pathToCurrentInstallation;
    exec($command, $lines, $return);

    if ($return > 0) {
        throw new RuntimeException(
            'following command created an error: "' . $command . '"' . PHP_EOL .
            'return: "' . $return . '"'
        );
    }

/*
sudo tar -zxf "$PHPSTORM" -C /opt/phpstorm

echo 'setting rights'
sudo chgrp -R "$GROUPNAME" /opt/phpstorm/
    sudo chmod -R 770 /opt/phpstorm/

echo 'done'
*/
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

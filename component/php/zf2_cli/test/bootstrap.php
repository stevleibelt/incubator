<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-06
 * @see https://github.com/ZF-Commons/ZfcUser/blob/master/tests/bootstrap.php
 */

chdir(__DIR__);

$loader = null;

if (file_exists('../vendor/autoload.php')) {
    $loader = include '../vendor/autoload.php';
} elseif (file_exists('../../../autoload.php')) {
    $loader = include '../../../autoload.php';
} else {
    throw new RuntimeException(
        'can not find "vendor/autoload.php"' . PHP_EOL .
        'no composer installed?'
    );
}

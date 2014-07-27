<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-23 
 */

require_once __DIR__ . '/../vendor/autoload.php';

//@todo replace with autoloader when own project
$files = array(
    'ExecutableInterface.php',
    'RuntimeException.php',
    'AbstractTask.php',
    'TaskManager.php',
    'ForkManagerFactory.php',
    'ForkManager.php'
);

foreach ($files as $file) {
    require_once __DIR__ . '/../' . $file;
}
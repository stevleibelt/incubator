<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-23 
 */

//@todo replace with autoloader when own project
$files = array(
    'ExecutableInterface.php',
    'RuntimeException.php',
    'AbstractTask.php',
    'MemoryLimitManager.php',
    'TaskManager.php',
    'TimeLimitManager.php',
    'ManagerFactory.php',
    'Manager.php'
);

foreach ($files as $file) {
    require_once __DIR__ . '/../' . $file;
}
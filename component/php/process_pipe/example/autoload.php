<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-11-07 
 */

$files = array(
    'ExecutableException.php',
    'ExecutableInterface.php',
    'PipeInterface.php',
    'Pipe.php'
);

foreach ($files as $file) {
    require_once __DIR__ . '/../source/De/Leibelt/ProcessPipe/' . $file;
}

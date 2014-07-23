<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

namespace Net\Bazzline\Component\Fork\Example\Basic;

require_once __DIR__ . '/../bootstrap.php';
require_once 'ExampleTask.php';

use Net\Bazzline\Component\Fork\Manager;

$manager = new Manager();
$totalNumberOfTasks = 7;

for ($iterator = 0; $iterator < $totalNumberOfTasks; ++$iterator) {
    $task = new ExampleTask();
    $manager->addTask($task);
}

$manager->execute();

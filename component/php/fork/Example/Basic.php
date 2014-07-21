<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

$files = array(
    'ExecutableInterface.php',
    'RuntimeException.php',
    'AbstractTask.php',
    'Manager.php'
);

foreach ($files as $file) {
    require_once __DIR__ . '/../' . $file;
}

/**
 * Class ExampleTask
 */
class ExampleTask extends \Net\Bazzline\Component\Fork\AbstractTask
{
    /**
     * @throws \Net\Bazzline\Component\Fork\RuntimeException
     */
    public function execute()
    {
        $identifier = 'task (' . posix_getpid() . ' / ' . $this->getParentProcessId() . ')';
        $startTime = time();

        echo $identifier . ' says hello' . PHP_EOL;
        sleep(rand(3, 7));
        echo $identifier . ' says goodbye' . PHP_EOL;
        echo $identifier . ' runtime: ' . (time() - $startTime) . ' seconds' . PHP_EOL;
        echo $identifier . ' memory usage: ' . (memory_get_usage(true)) . ' bytes' . PHP_EOL;
    }
}

$manager = new \Net\Bazzline\Component\Fork\Manager();
$totalNumberOfTasks = 7;

for ($iterator = 0; $iterator < $totalNumberOfTasks; ++$iterator) {
    $task = new ExampleTask();
    $manager->addTask($task);
}

$manager->execute();

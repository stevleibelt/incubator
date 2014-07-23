<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

//@todo replace with autoloader when own project
$files = array(
    'ExecutableInterface.php',
    'RuntimeException.php',
    'AbstractTask.php',
    'MemoryLimitManager.php',
    'TimeLimitManager.php',
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
     * @var int
     */
    private $runTime = 1;

    /**
     * @return int
     */
    public function getRunTime()
    {
        return $this->runTime;
    }

    /**
     * @param int $runTime
     */
    public function setRunTime($runTime)
    {
        $this->runTime = $runTime;
    }

    /**
     * @throws \Net\Bazzline\Component\Fork\RuntimeException
     */
    public function execute()
    {
        $identifier = 'task (' . posix_getpid() . ' / ' . $this->getParentProcessId() . ')';
        $startTime = time();

        echo $identifier . ' says hello' . PHP_EOL;
        sleep($this->runTime);
        echo $identifier . ' says goodbye' . PHP_EOL;
        echo $identifier . ' runtime: ' . (time() - $startTime) . ' seconds' . PHP_EOL;
        echo $identifier . ' memory usage: ' . (memory_get_usage(true)) . ' bytes' . PHP_EOL;
    }
}

$manager = new \Net\Bazzline\Component\Fork\Manager();
/**
 * @var array|ExampleTask[] $tasks
 */
$maximumRunTimeInSeconds = 9;

$taskOne = new ExampleTask();
$taskTwo = new ExampleTask();
$taskThree = new ExampleTask();

$taskOne->setRunTime(($maximumRunTimeInSeconds - 3)); //there is an offset of 2 seconds
$taskTwo->setRunTime($maximumRunTimeInSeconds);
$taskThree->setRunTime(($maximumRunTimeInSeconds + 1));

$tasks = array(
    1 => $taskOne,
    2 => $taskTwo,
    3 => $taskThree
);

foreach ($tasks as $task) {
    $manager->addTask($task);
}

$manager->setMaximumSecondsOfRunTime($maximumRunTimeInSeconds);
$manager->execute();

foreach ($tasks as $key => $task) {
    $status = ($task->isAborted()) ?
        'aborted' : (($task->isFinished()) ?
            'finished' : 'not finished');
    echo 'task ' . $key . ' with run time of ' . $task->getRunTime() . ' seconds has been ' . $status . PHP_EOL;
}

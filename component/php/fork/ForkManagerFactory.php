<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-24 
 */

namespace Net\Bazzline\Component\Fork;

/**
 * Class ForkManagerFactory
 * @package Net\Bazzline\Component\Fork
 */
class ForkManagerFactory
{
    /**
     * @return ForkManager
     */
    public function create()
    {
        $memoryLimitManager = new MemoryLimitManager();
        $taskManager = new TaskManager();
        $timeLimitManager = new TimeLimitManager();

        //set default values for optional properties
        $memoryLimitManager->setMaximumInMegaBytes(128);
        $memoryLimitManager->setBufferInMegaBytes(8);

        $timeLimitManager->setMaximumInSeconds(3600); //1 * 60 * 60 = 1 hour
        $timeLimitManager->setBufferInSeconds(2);

        $manager = new ForkManager($memoryLimitManager, $taskManager, $timeLimitManager);

        $manager->setMaximumNumberOfThreads(16);
        $manager->setNumberOfMicrosecondsToCheckThreadStatus(100000);   //1000000 microseconds = 1 second

        return $manager;
    }
} 
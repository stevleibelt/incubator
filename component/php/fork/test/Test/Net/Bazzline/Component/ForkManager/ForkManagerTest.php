<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-28
 */

namespace Test\Net\Bazzline\Component\ForkManager;

use Net\Bazzline\Component\ForkManager\ForkManager;

/**
 * Class ForkManagerTest
 * @package Test\Net\Bazzline\Component\ForkManager
 */
class ForkManagerTest extends ForkManagerTestCase
{
    public function testGetterAndInjects()
    {
        $manager = new ForkManager();
        $memoryLimitManager = $this->getMockOfMemoryLimitManager();
        $taskManager = $this->getMockOfTaskManager();
        $timeLimitManager = $this->getMockOfTimeLimitManager();

        $this->assertNull($manager->getMemoryLimitManager());
        $this->assertNull($manager->getTaskManager());
        $this->assertNull($manager->getTimeLimitManager());

        $manager->injectMemoryLimitManager($memoryLimitManager);
        $manager->injectTaskManager($taskManager);
        $manager->injectTimeLimitManager($timeLimitManager);

        $this->assertEquals($memoryLimitManager, $manager->getMemoryLimitManager());
        $this->assertEquals($taskManager, $manager->getTaskManager());
        $this->assertEquals($timeLimitManager, $manager->getTimeLimitManager());
    }

    public function testAddTask()
    {
        $manager = $this->getNewManager();
        $processId = getmypid();
        $task = $this->getMockOfAbstractTask();
        /** @var \Mockery\MockInterface|\Net\Bazzline\Component\ForkManager\TaskManager $taskManager */
        $taskManager = $manager->getTaskManager();

        $task->shouldReceive('setParentProcessId')
            ->with($processId)
            ->once();
        $taskManager->shouldReceive('addOpenTask')
            ->with($task)
            ->once();
        $manager->injectTaskManager($taskManager);

        $manager->addTask($task);
    }

    public function testExecuteWithNoTask()
    {
        $manager = $this->getNewManager();
        /** @var \Mockery\MockInterface|\Net\Bazzline\Component\ForkManager\TaskManager $taskManager */
        $taskManager = $manager->getTaskManager();

        $taskManager->shouldReceive('areThereOpenTasksLeft')
            ->andReturn(false)
            ->once();

        $manager->execute();
    }

    public function testExecuteWithOneTask()
    {
$this->markTestIncomplete();
    }

    public function testExecuteWithTasks()
    {
$this->markTestIncomplete();
    }

    public function testExecuteWithOneTasksWhileTimeLimitIsReached()
    {
$this->markTestIncomplete();
    }

    public function testExecuteWithTasksWhileMemoryLimitIsReached()
    {
$this->markTestIncomplete();
    }

    public function testExecuteWithTasksWhileReachingMaximumNumberOfThreads()
    {
$this->markTestIncomplete();
    }

    /**
     * @return ForkManager
     */
    private function getNewManager()
    {
        $manager = new ForkManager();

        $manager->injectMemoryLimitManager($this->getMockOfMemoryLimitManager());
        $manager->injectTaskManager($this->getMockOfTaskManager());
        $manager->injectTimeLimitManager($this->getMockOfTimeLimitManager());

        return $manager;
    }
} 
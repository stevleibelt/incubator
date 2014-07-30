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
        $processId = getmypid();
        $manager = $this->getNewManager();
        /** @var \Mockery\MockInterface|\Net\Bazzline\Component\MemoryLimitManager\MemoryLimitManager $memoryLimitManager */
        $memoryLimitManager = $manager->getMemoryLimitManager();
        /** @var \Mockery\MockInterface|\Net\Bazzline\Component\ForkManager\TaskManager $taskManager */
        $taskManager = $manager->getTaskManager();
        $task = $this->getMockOfAbstractTask();
        /** @var \Mockery\MockInterface|\Net\Bazzline\Component\TimeLimitManager\TimeLimitManager $timeLimitManager */
        $timeLimitManager = $manager->getTimeLimitManager();

        $task->shouldReceive('setParentProcessId')
            ->with($processId)
            ->once();
        $taskManager->shouldReceive('addOpenTask')
            ->with($task)
            ->once();

        $memoryLimitManager->shouldReceive('isLimitReached')
            ->withAnyArgs()
            ->andReturn(false);
        $taskManager->shouldReceive('areThereOpenTasksLeft')
            ->andReturn(true, false)
            ->twice();
        $timeLimitManager->shouldReceive('isLimitReached')
            ->andReturn(false);

        $manager->addTask($task);
        $manager->execute();
    }

    public function testExecuteWithTasks()
    {
        $processId = getmypid();
        $manager = $this->getNewManager();
        /** @var \Mockery\MockInterface|\Net\Bazzline\Component\MemoryLimitManager\MemoryLimitManager $memoryLimitManager */
        $memoryLimitManager = $manager->getMemoryLimitManager();
        /** @var \Mockery\MockInterface|\Net\Bazzline\Component\ForkManager\TaskManager $taskManager */
        $taskManager = $manager->getTaskManager();
        /** @var \Mockery\MockInterface|\Net\Bazzline\Component\TimeLimitManager\TimeLimitManager $timeLimitManager */
        $timeLimitManager = $manager->getTimeLimitManager();

        $firstTask = $this->getMockOfAbstractTask();
        $secondTask = $this->getMockOfAbstractTask();
        $thirdTask = $this->getMockOfAbstractTask();

        $firstTask->shouldReceive('setParentProcessId')
            ->with($processId)
            ->once();
        $secondTask->shouldReceive('setParentProcessId')
            ->with($processId)
            ->once();
        $thirdTask->shouldReceive('setParentProcessId')
            ->with($processId)
            ->once();

        $taskManager->shouldReceive('addOpenTask')
            ->with($firstTask)
            ->once();
        $taskManager->shouldReceive('addOpenTask')
            ->with($secondTask)
            ->once();
        $taskManager->shouldReceive('addOpenTask')
            ->with($thirdTask)
            ->once();

        $memoryLimitManager->shouldReceive('isLimitReached')
            ->withAnyArgs()
            ->andReturn(false);
        $taskManager->shouldReceive('areThereOpenTasksLeft')
            ->andReturn(true, false)
            ->twice();
        $timeLimitManager->shouldReceive('isLimitReached')
            ->andReturn(false);

        $manager->addTask($firstTask);
        $manager->addTask($secondTask);
        $manager->addTask($thirdTask);
        $manager->execute();
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
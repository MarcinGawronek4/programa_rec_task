<?php

namespace Tests\Domain\Task;

use App\Domain\Task\Task;
use App\Domain\Task\TaskFactory;
use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

class TaskFactoryTest extends TestCase
{
    private TaskFactory $taskFactory;

    protected function setUp(): void
    {
        $this->taskFactory = new TaskFactory();
    }

    public function testFactoryCreatesValidTaskInstance(): void
    {
        $user = $this->createMock(User::class);
        $task = $this->taskFactory->create("Test Task", "This is a test task", $user);

        $this->assertInstanceOf(Task::class, $task, "TaskFactory should return an instance of Task");
    }

    public function testFactorySetsCorrectNameAndDescription(): void
    {
        $user = $this->createMock(User::class);
        $task = $this->taskFactory->create("Test Task", "This is a test task", $user);

        $this->assertEquals("Test Task", $task->getName(), "Task name should be set correctly");
        $this->assertEquals("This is a test task", $task->getDescription(), "Task description should be set correctly");
    }

    public function testFactoryAssignsUserCorrectly(): void
    {
        $user = $this->createMock(User::class);
        $task = $this->taskFactory->create("Test Task", "This is a test task", $user);

        $this->assertSame($user, $task->getAssignedUser(), "Task should be assigned to the correct user");
    }

    public function testFactorySetsDefaultStatus(): void
    {
        $user = $this->createMock(User::class);
        $task = $this->taskFactory->create("Test Task", "This is a test task", $user);

        $this->assertEquals("to_do", $task->getStatus(), "Newly created tasks should have 'to_do' status by default");
    }

    public function testFactoryHandlesNullDescription(): void
    {
        $user = $this->createMock(User::class);
        $task = $this->taskFactory->create("Test Task", null, $user);

        $this->assertNull($task->getDescription(), "Task description should be null if not provided");
    }

    public function testFactoryThrowsErrorOnInvalidUser(): void
    {
        $this->expectException(\TypeError::class);

        $this->taskFactory->create("Test Task", "This should fail", null);
    }
}
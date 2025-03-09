<?php

namespace App\Application\EventListener;

use App\Domain\Task\Event\TaskUpdatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TaskUpdatedEventListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(TaskUpdatedEvent $event): void
    {
        $this->logger->info("Task ID {$event->taskId} status changed from '{$event->oldStatus}' to '{$event->newStatus}'");
    }
}
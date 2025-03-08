<?php

namespace App\Application\EventListener;

use App\Domain\Task\Event\TaskCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TaskCreatedEventListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(TaskCreatedEvent $event): void
    {
        $this->logger->info("Task Created: ID {$event->taskId}, Name: {$event->name}");
    }
}
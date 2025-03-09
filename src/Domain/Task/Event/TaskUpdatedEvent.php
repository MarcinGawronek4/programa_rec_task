<?php

namespace App\Domain\Task\Event;

class TaskUpdatedEvent
{
    public function __construct(
        public readonly int $taskId,
        public readonly string $oldStatus,
        public readonly string $newStatus
    ) {}
}
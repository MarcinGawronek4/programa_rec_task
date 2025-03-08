<?php

namespace App\Domain\Task\Event;

class TaskCreatedEvent
{
    public function __construct(
        public readonly int $taskId,
        public readonly string $name,
        public readonly ?string $description,
        public readonly string $status,
        public readonly int $assigned_user_id
    ) {}
}
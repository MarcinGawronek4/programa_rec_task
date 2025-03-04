<?php

namespace App\Infrastructure\Task;

use App\Domain\Task;
use App\Domain\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function save(Task $task): void
    {
        $this->_em->persist($task);
        $this->_em->flush();
    }

    public function findByUser(User $user): array
    {
        return $this->findBy(['assignedUser' => $user]);
    }
}
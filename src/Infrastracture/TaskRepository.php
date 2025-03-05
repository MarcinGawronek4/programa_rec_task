<?php

namespace App\Infrastructure;

use App\Domain\Task;
use App\Domain\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Task $task): void
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function findByUser(User $user): array
    {
        return $this->findBy(['assignedUser' => $user]);
    }
}
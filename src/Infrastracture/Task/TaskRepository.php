<?php

namespace App\Infrastructure\Task;

use App\Domain\Task\Task;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Domain\User\User;

class TaskRepository
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Task::class);
    }

    public function findAll(User $user): array
    {
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->repository->findBy([], ['id' => 'DESC']);
        }

        return $this->repository->findBy(['assignedUser' => $user], ['id' => 'DESC']);
    }

    public function save(Task $task): void
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
}
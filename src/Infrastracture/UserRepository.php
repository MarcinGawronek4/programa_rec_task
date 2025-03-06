<?php

namespace App\Infrastructure;

use App\Domain\User\User;
use App\Domain\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserRepository implements UserRepositoryInterface
{
    private HttpClientInterface $httpClient;
    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function fetchAll(): array
    {
        $response = $this->httpClient->request('GET', 'https://jsonplaceholder.typicode.com/users');
        $data = $response->toArray();

        return array_map(fn($user) => new User(
            $user['name'], 
            $user['email'], 
            $user['username'],
            'test'
        ), $data);
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function saveMultiple(array $users): void
    {
        foreach ($users as $user) {
            $this->entityManager->persist($user);
        }
        $this->entityManager->flush();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }
}
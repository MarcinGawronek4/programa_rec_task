<?php

namespace App\Infrastructure;

use App\Domain\User;
use App\Domain\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    private HttpClientInterface $httpClient;
    private EntityManagerInterface $entityManager;

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager)
    {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
    }

    public function fetchAll(): array
    {
        $response = $this->httpClient->request('GET', 'https://jsonplaceholder.typicode.com/users');
        $data = $response->toArray();

        return array_map(fn($user) => new User(
            $user['name'], 
            $user['email'], 
            $user['username'],
            'hashed_password_placeholder'
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
        return $this->findOneBy(['email' => $email]);
    }
}
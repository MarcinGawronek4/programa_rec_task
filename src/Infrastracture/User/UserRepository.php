<?php

namespace App\Infrastructure\User;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Domain\User\UserFactory;

class UserRepository implements UserRepositoryInterface
{
    private HttpClientInterface $httpClient;
    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;
    private UserFactory $userFactory;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $httpClient, UserFactory $userFactory)
    {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->userFactory = $userFactory;
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function fetchAll(): array
    {
        $response = $this->httpClient->request('GET', 'https://jsonplaceholder.typicode.com/users');
        $data = $response->toArray();

        return array_map(fn($user) => $this->userFactory->create($user['username'], 'test', $user['name'], $user['email'], $user['username'] == 'Samantha' ? ['ROLE_USER', 'ROLE_ADMIN'] : ['ROLE_USER']), $data );
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

    public function findById(int $id): ?User
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    public function findByUsername(string $username): ?User
    {
        return $this->repository->findOneBy(['username' => $username]);
    }

    public function findAll(): array
    {
        return $this->repository->findBy([], ['id' => 'DESC']); // Get tasks sorted by newest
    }
}
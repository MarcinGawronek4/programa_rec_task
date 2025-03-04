<?php

namespace App\Infrastructure;

use App\Domain\User;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserRepository
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetchAll(): array
    {
        $response = $this->httpClient->request('GET', 'https://jsonplaceholder.typicode.com/users');
        $data = $response->toArray();

        $users = [];
        foreach ($data as $userData) {
            $users[] = new User(
                $userData['id'],
                $userData['name'],
                $userData['email'],
                $userData['username']
            );
        }

        return $users;
    }
}
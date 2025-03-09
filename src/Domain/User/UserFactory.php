<?php

namespace App\Domain\User;

class UserFactory
{
    public function create(string $username, string $password, array $roles = ['ROLE_USER']): User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password); // Plaintext for now
        $user->setRoles($roles);

        return $user;
    }
}
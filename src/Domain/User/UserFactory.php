<?php

namespace App\Domain\User;

class UserFactory
{
    public function create(string $username, string $password,string $name, string $email, array $roles = ['ROLE_USER']): User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password); 
        $user->setRoles($roles);
        $user->setName($name);
        $user->setEmail($email);

        return $user;
    }
}
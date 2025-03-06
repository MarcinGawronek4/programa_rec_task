<?php

namespace App\Domain;

use App\Domain\User\User;

interface UserRepositoryInterface
{
    public function fetchAll(): array;
    public function saveMultiple(array $users): void;
    public function save(User $user): void;
}
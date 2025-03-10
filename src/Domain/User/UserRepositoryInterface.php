<?php

namespace App\Domain\User;

use App\Domain\User\User;

interface UserRepositoryInterface
{
    public function fetchAll(): array;
    public function findAll(): array;
    public function saveMultiple(array $users): void;
    public function save(User $user): void;
    public function findById(int $id): ?User;
}
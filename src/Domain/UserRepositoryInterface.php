<?php

namespace App\Domain;

interface UserRepositoryInterface
{
    public function fetchAll(): array;
    public function saveMultiple(array $users): void;
}
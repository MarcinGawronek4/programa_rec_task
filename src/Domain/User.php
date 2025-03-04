<?php

namespace App\Domain;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $username;

    public function __construct(int $id, string $name, string $email, string $username)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->username = $username;
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getUsername(): string { return $this->username; }
}
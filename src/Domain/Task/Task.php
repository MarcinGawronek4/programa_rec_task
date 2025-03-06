<?php

namespace App\Domain\Task;

use App\Domain\User\User;
use Doctrine\ORM\Mapping as ORM;
use App\Infrastructure\TaskRepository;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\Table(name: "tasks")]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\Column(type: "string", length: 50)]
    private string $status;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "tasks")]
    #[ORM\JoinColumn(nullable: false)]
    private User $assignedUser;

    public function __construct(string $name, string $description, string $status, User $assignedUser)
    {
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
        $this->assignedUser = $assignedUser;
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getStatus(): string { return $this->status; }
    public function getAssignedUser(): User { return $this->assignedUser; }

    public function setStatus(string $status): void { $this->status = $status; }
}
<?php

namespace App\Domain\Task;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "tasks")]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "string", length: 50)]
    private string $status = 'to_do'; // Default status

    #[ORM\Column(type: "integer", length: 50)]
    private string $assigned_user_id = '1'; // Default status

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }
    public function setAssignedUserId(int $assigned_user_id): self { $this->assigned_user_id = $assigned_user_id; return $this; }
}
<?php

namespace App\Domain;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Domain\Task;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\User\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $username;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="assignedUser")
     */
    private Collection $tasks;
    

    public function __construct(string $name, string $email, string $username, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getUsername(): string { return $this->username; }
    public function getPassword(): string { return $this->password; }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRoles(): array { return ['ROLE_USER']; }
    public function getSalt() {}
    public function eraseCredentials(): void {}
    public function getUserIdentifier(): string { return $this->id; }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }
}
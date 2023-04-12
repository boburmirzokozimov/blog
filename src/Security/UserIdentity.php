<?php

namespace App\Security;

use App\Model\User\Entity\Name;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserIdentity implements UserInterface, PasswordAuthenticatedUserInterface, EquatableInterface
{
    public function __construct(private ?string $id,
                                private ?Name   $name,
                                private ?string $email,
                                private ?string $password,
                                private ?string $role,
    )
    {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?Name
    {
        return $this->name;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function eraseCredentials()
    {
        return null;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof self) {
            return false;
        }

        return $this->email === $user->getEmail() && $this->id === $user->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
<?php

namespace App\Model\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;
use DomainException;
use Ramsey\Uuid\Uuid;

#[ORM\Table(name: 'user_users')]
#[ORM\Entity()]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[Embedded(class: Name::class)]
    private Name $name;

    #[ORM\Column(type: 'string')]
    private string $email;

    #[ORM\Column(type: 'string')]
    private string $password_hash;

    #[ORM\Column(type: 'string')]
    private string $password_plain;

    #[ORM\Column(type: 'string')]
    private string $confirm_token;

    #[ORM\Column(type: 'user_status')]
    private Status $status;

    #[ORM\Column(type: 'user_role')]
    private Role $role;

    public function __construct(Name $name, string $email, string $password_hash, string $password_plain, string $confirm_token)
    {
        $this->id = substr(Uuid::uuid4()->toString(), 0, 6);
        $this->name = $name;
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->password_plain = $password_plain;
        $this->confirm_token = $confirm_token;
    }

    public static function createUser(Name $name, string $email, string $password_hash, string $password_plain, string $confirm_token): self
    {
        $user = new self($name, $email, $password_hash, $password_plain, $confirm_token);
        $user->status = Status::wait();
        $user->role = Role::user();
        return $user;
    }

    public static function createManager(Name $name, string $email, string $password_hash, string $password_plain, string $confirm_token): self
    {
        $user = new self($name, $email, $password_hash, $password_plain, $confirm_token);
        $user->activate();
        $user->role = Role::manager();
        return $user;
    }

    public function activate(): void
    {
        if ($this->status->isActive()) {
            throw new DomainException('User is already activated');
        }
        $this->status = Status::active();
    }

    public static function createAdmin(Name $name, string $email, string $password_hash, string $password_plain, string $confirm_token): self
    {
        $user = new self($name, $email, $password_hash, $password_plain, $confirm_token);
        $user->activate();
        $user->role = Role::admin();
        return $user;
    }

    public function block(): void
    {
        if ($this->status->isBlocked()) {
            throw new DomainException('User is already blocked');
        }
        $this->status = Status::block();
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    public function getPasswordPlain(): string
    {
        return $this->password_plain;
    }

    public function getConfirmToken(): string
    {
        return $this->confirm_token;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function isEqual(int $value): bool
    {
        return $this->id === $value;
    }

    public function edit(Name $name): void
    {
        $this->name = $name;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function confirmSignUp(): void
    {
        if (!$this->status->isWait()) {
            throw new DomainException('User is already active');
        }
        $this->status = Status::active();
        $this->confirm_token = '';
    }

}
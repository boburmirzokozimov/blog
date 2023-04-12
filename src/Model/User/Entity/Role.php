<?php

namespace App\Model\User\Entity;

use Webmozart\Assert\Assert;

class Role
{
    public const  MANAGER = 'ROLE_MANAGER';
    public const ADMIN = 'ROLE_ADMIN';
    public const USER = 'ROLE_USER';

    private string $role;

    public function __construct(string $role)
    {
        Assert::oneOf($role, [
            self::MANAGER,
            self::ADMIN,
            self::USER,
        ]);
        $this->role = $role;
    }

    public static function manager(): self
    {
        return new self(self::MANAGER);
    }

    public static function admin(): self
    {
        return new self(self::ADMIN);
    }

    public static function user(): self
    {
        return new self(self::USER);
    }


    public function isManager(): bool
    {
        return $this->role === self::MANAGER;
    }

    public function isUser(): bool
    {
        return $this->role === self::USER;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ADMIN;
    }

    public function getRole(): string
    {
        return $this->role;
    }

}
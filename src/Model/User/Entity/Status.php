<?php

namespace App\Model\User\Entity;

use Webmozart\Assert\Assert;

class Status
{
    public const WAIT = 'wait';
    public const ACTIVE = 'active';
    public const BLOCKED = 'blocked';

    private string $value;

    public function __construct(string $status)
    {
        Assert::oneOf($status, [
            self::WAIT,
            self::ACTIVE,
            self::BLOCKED,
        ]);
        $this->value = $status;
    }

    public static function wait(): self
    {
        return new self(self::WAIT);
    }

    public static function active(): self
    {
        return new self(self::ACTIVE);
    }

    public static function block(): self
    {
        return new self(self::BLOCKED);
    }

    public function isActive(): bool
    {
        return $this->value === self::ACTIVE;
    }

    public function isBlocked(): bool
    {
        return $this->value === self::BLOCKED;
    }

    public function isWait(): bool
    {
        return $this->value === self::WAIT;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
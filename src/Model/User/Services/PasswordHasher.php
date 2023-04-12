<?php

namespace App\Model\User\Services;

use RuntimeException;

class PasswordHasher
{
    public static function hash(string $password): string
    {
        $hash = password_hash($password, PASSWORD_ARGON2I);
        if (!$hash) {
            throw new RuntimeException('Unable to generate hash.');
        }
        return $hash;
    }

    public function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
<?php

namespace App\Model\User\Services;

use Ramsey\Uuid\Uuid;

class SignUpConfirmTokenizer
{
    public static function next(): self
    {
        return Uuid::uuid4()->toString();
    }
}
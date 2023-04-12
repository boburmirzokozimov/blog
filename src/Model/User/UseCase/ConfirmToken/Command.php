<?php

namespace App\Model\User\UseCase\ConfirmToken;

class Command
{
    public function __construct(private string $token)
    {
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
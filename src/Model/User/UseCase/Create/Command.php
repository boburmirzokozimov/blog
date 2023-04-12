<?php

namespace App\Model\User\UseCase\Create;

class Command
{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $password;
}
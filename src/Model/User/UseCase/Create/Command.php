<?php

namespace App\Model\User\UseCase\Create;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class Command
{
    #[NotBlank]
    public string $firstName;

    #[NotBlank]
    public string $lastName;

    #[NotBlank]
    #[Email]
    public string $email;

    #[NotBlank]
    public string $password;
}
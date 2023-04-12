<?php

namespace App\Model\User\UseCase\ConfirmToken;

use App\Model\Flusher;
use App\Model\User\Entity\UserRepository;
use DomainException;

class Handler
{
    public function __construct(private Flusher        $flusher,
                                private UserRepository $repository)
    {
    }

    public function handle(Command $command): void
    {
        if (!$user = $this->repository->findUserByToken($command->getToken())) {
            throw new DomainException('User with this token was not found');
        }

        $user->confirmSignUp();

        $this->flusher->flush();
    }
}
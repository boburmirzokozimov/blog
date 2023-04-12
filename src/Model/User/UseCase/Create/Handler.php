<?php

namespace App\Model\User\UseCase\Create;

use App\Model\Flusher;
use App\Model\User\Entity\Name;
use App\Model\User\Entity\User;
use App\Model\User\Entity\UserRepository;
use App\Model\User\Services\PasswordHasher;
use App\Model\User\Services\SignUpConfirmTokenizer;
use App\Model\User\Services\SignUpConfirmTokenSender;
use DomainException;

class Handler
{
    public function __construct(private Flusher                  $flusher,
                                private UserRepository           $repository,
                                private SignUpConfirmTokenSender $sender)
    {
    }

    public function handle(Command $command): void
    {
        if ($this->repository->existByEmail($command->email)) {
            throw new DomainException('User with this email address already exists');
        }

        $token = SignUpConfirmTokenizer::next();
        
        $user = User::createUser(
            new Name($command->firstName, $command->lastName),
            $command->email,
            PasswordHasher::hash($command->password),
            $command->password,
            $token,
        );

        $this->repository->add($user);

        $this->flusher->flush();

        $this->sender->sendEmail($command->firstName, $command->lastName, $command->email, $token);
    }
}
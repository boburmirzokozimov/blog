<?php

namespace App\Model\User\UseCase\Create;

use App\Model\Flusher;
use App\Model\User\Entity\Name;
use App\Model\User\Entity\User;
use App\Model\User\Entity\UserRepository;
use App\Model\User\Services\PasswordHasher;
use App\Model\User\Services\SignUpConfirmTokenizer;
use App\Model\User\Services\SignUpConfirmTokenSender;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class Handler
{
    public function __construct(private Flusher                  $flusher,
                                private UserRepository           $repository,
                                private SignUpConfirmTokenSender $sender)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function handle(Command $command): void
    {
        $token = SignUpConfirmTokenizer::next();
        $user = new User(
            new Name($command->firstName, $command->lastName),
            $command->email,
            PasswordHasher::hash($command->password),
            $command->password,
            SignUpConfirmTokenizer::next(),
        );

        $this->repository->add($user);

        $this->flusher->flush();

        $this->sender->sendEmail($command->firstName, $command->lastName, $command->email, $token);
    }
}
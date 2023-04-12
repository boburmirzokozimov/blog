<?php

namespace App\Model\User\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository
{
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(User::class);
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }

    public function remove(User $user): void
    {
        $this->em->remove($user);
    }

    public function get(string $id): User
    {
        return $this->repository->find($id);
    }

    public function findUserByToken(string $token): ?User
    {
        return $this->repository->findOneBy(['confirm_token' => $token]);
    }

    public function existByEmail(string $email): bool
    {
        return $this->repository->createQueryBuilder('u')
                ->select('COUNT(u.email)')
                ->where('u.email = :email')
                ->setParameter('email', $email)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}
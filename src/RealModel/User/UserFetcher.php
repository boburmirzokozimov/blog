<?php

namespace App\RealModel\User;

use Doctrine\DBAL\Connection;
use Symfony\Component\Serializer\SerializerInterface;

class UserFetcher
{
    public function __construct(private Connection $connection, private SerializerInterface $serializer)
    {
    }

    public function loadUserByEmail(string $email): ?AuthView
    {
        $qb = $this->connection->createQueryBuilder()
            ->select('u.id',
                'u.name_first',
                'u.name_last',
                'u.email',
                'u.password_hash as password',
                'u.role',
            )
            ->from('user_users', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->executeQuery()
            ->fetchAssociative();

        if ($qb) {
            return $this->serializer->denormalize($qb, AuthView::class);
        } else {
            return null;
        }

    }
}
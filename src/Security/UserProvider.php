<?php

namespace App\Security;

use App\Model\User\Entity\Name;
use App\RealModel\User\AuthView;
use App\RealModel\User\UserFetcher;
use DomainException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Serializer\Exception\UnsupportedException;

class UserProvider implements UserProviderInterface
{
    public function __construct(private UserFetcher $fetcher)
    {
    }

    public function refreshUser(UserInterface $user): UserIdentity
    {
        if (!$user instanceof UserIdentity) {
            throw new UnsupportedException('Invalid user class ' . get_class($user));
        }
        $newUser = $this->fetcher->loadUserByEmail($user->getUserIdentifier());

        return self::identityByUser($newUser);
    }

    private static function identityByUser(AuthView $user): UserIdentity
    {
        return new UserIdentity(
            $user->id,
            new Name($user->name_first, $user->name_last),
            $user->email,
            $user->password,
            $user->role
        );
    }

    public function supportsClass(string $class): bool
    {
        return UserIdentity::class === $class || is_subclass_of($class, UserIdentity::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        if (!$user = $this->fetcher->loadUserByEmail($identifier)) {
            throw new  DomainException('Unable to load user by identifier.');
        }

        return self::identityByUser($user);
    }

}
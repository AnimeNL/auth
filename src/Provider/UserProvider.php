<?php

namespace App\Provider;

use App\Entity\Anplan\User;
use App\Repository\Anplan\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private UserRepository $userRepo;
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine, UserRepository $userRepo)
    {
        $this->doctrine = $doctrine;
        $this->userRepo = $userRepo;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username): ?User
    {
        $user = $this->userRepo->findOneByUsername($username);

        if (!$user) {
            $exception = new UsernameNotFoundException();
            $exception->setUsername($username);

            throw $exception;
        }

        return $user;
    }

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException  if the user is not supported
     * @throws UsernameNotFoundException if the user is not found
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return User::class === $class;
    }

    /**
     * Updates password hashing method.
     */
    public function updatePassword(User $user, string $password): User
    {
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $em = $this->doctrine->getManager('anplan');
        $em->persist($user);
        $em->flush();

        return $user;
    }
}

<?php

namespace App\EventListener;

use App\Entity\Anplan\User;
use App\Provider\UserProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\UserResolveEvent;

final class UserResolveListener
{
    /**
     * @var UserProvider
     */
    private $userProvider;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     * @var bool
     */
    private $updatePassword;

    /**
     * @param UserProviderInterface        $userProvider
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param bool                         $updatePassword
     */
    public function __construct(
        UserProviderInterface $userProvider,
        UserPasswordEncoderInterface $userPasswordEncoder,
        bool $updatePassword = false
    ) {
        $this->userProvider = $userProvider;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->updatePassword = $updatePassword;
    }

    /**
     * @param UserResolveEvent $event
     */
    public function onUserResolve(UserResolveEvent $event): void
    {
        /** @var User $user */
        $user = $this->userProvider->loadUserByUsername($event->getUsername());

        if (null === $user) {
            return;
        }

        if (!$this->userPasswordEncoder->isPasswordValid($user, $event->getPassword())) {
            return;
        }

        if ($this->updatePassword && $user->getEncoderName() === 'legacy') {
            $this->userProvider->updatePassword($user, $event->getPassword());
        }

        $event->setUser($user);
    }
}

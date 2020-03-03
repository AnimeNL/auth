<?php

namespace App\EventListener;

use App\Provider\UserProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\UserResolveEvent;

final class UserResolveListener
{
    private UserProvider $userProvider;
    private UserPasswordEncoderInterface $userPasswordEncoder;
    private bool $updatePassword;

    public function __construct(
        UserProvider $userProvider,
        UserPasswordEncoderInterface $userPasswordEncoder,
        bool $updatePassword = false
    ) {
        $this->userProvider = $userProvider;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->updatePassword = $updatePassword;
    }

    public function onUserResolve(UserResolveEvent $event): void
    {
        $user = $this->userProvider->loadUserByUsername($event->getUsername());

        if (null === $user) {
            return;
        }

        if (!$this->userPasswordEncoder->isPasswordValid($user, $event->getPassword())) {
            return;
        }

        if ($this->updatePassword && 'legacy' === $user->getEncoderName()) {
            $this->userProvider->updatePassword($user, $event->getPassword());
        }

        $event->setUser($user);
    }
}

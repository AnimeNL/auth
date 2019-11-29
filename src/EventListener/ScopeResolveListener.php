<?php

namespace App\EventListener;

use App\Provider\UserProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\ScopeResolveEvent;

final class ScopeResolveListener
{
    private UserProvider $userProvider;

    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public function onScopeResolve(ScopeResolveEvent $event): void
    {
        $user = $this->userProvider->loadUserByUsername($event->getUserIdentifier());
        if (!$user instanceof UserInterface) {
            return;
        }
        $event->setScopes(...$user->getRoles());
    }
}

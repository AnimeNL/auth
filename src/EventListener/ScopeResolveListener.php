<?php

namespace App\EventListener;

use App\Provider\UserProvider;
use Trikoder\Bundle\OAuth2Bundle\Event\ScopeResolveEvent;

final class ScopeResolveListener
{
    /**
     * @var UserProvider
     */
    private $userProvider;

    /**
     * ScopeResolveListener constructor.
     *
     * @param UserProvider $userProvider
     */
    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public function onScopeResolve(ScopeResolveEvent $event): void
    {
        //$requestedScopes = $event->getScopes();
        $user = $this->userProvider->loadUserByUsername($event->getUserIdentifier());
        $event->setScopes(...$user->getRoles());
    }
}

<?php

namespace App\EventListener;

use App\Normalizer\ScopeNormalizer;
use App\Provider\UserProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\ScopeResolveEvent;
use Trikoder\Bundle\OAuth2Bundle\Model\Scope;

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
        $scopes = array_map(fn (Scope $scope) => ScopeNormalizer::normalize($scope), $user->getRoles());
        $event->setScopes(...$scopes);
    }
}

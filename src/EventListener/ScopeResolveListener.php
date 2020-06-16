<?php

namespace App\EventListener;

use App\Entity\Anplan\Scope;
use App\Normalizer\ScopeNormalizer;
use App\Provider\UserProvider;
use App\Repository\Anplan\ScopeRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\ScopeResolveEvent;

final class ScopeResolveListener
{
    private UserProvider $userProvider;
    private ScopeRepository $scopeRepository;

    public function __construct(UserProvider $userProvider, ScopeRepository $scopeRepository)
    {
        $this->userProvider = $userProvider;
        $this->scopeRepository = $scopeRepository;
    }

    public function onScopeResolve(ScopeResolveEvent $event): void
    {
        $user = $this->userProvider->loadUserByUsername($event->getUserIdentifier());
        if (!$user instanceof UserInterface) {
            return;
        }
        $scopes = array_map(
            fn (Scope $scope) => ScopeNormalizer::normalize($scope),
            $this->scopeRepository->getUserScopes($user->getId(), $event->getScopes())
        );
        $event->setScopes(...$scopes);
    }
}

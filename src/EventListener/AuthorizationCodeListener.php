<?php

namespace App\EventListener;

use Symfony\Component\Security\Core\Security;
use Trikoder\Bundle\OAuth2Bundle\Event\AuthorizationRequestResolveEvent;

final class AuthorizationCodeListener
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function onAuthorizationRequestResolve(AuthorizationRequestResolveEvent $event)
    {
        if (null !== ($user = $this->security->getUser())) {
            $event->setUser($user);
            $event->resolveAuthorization(true);
        }
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    public function handleRequest(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        if (!$this->handleOauthRequest($request)) {
            return $this->render('login/invalid_request.html.twig');
        }

        return $this->render('login/default.html.twig', [
            'lastUsername' => $authenticationUtils->getLastUsername(),
            'lastError' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    private function handleOauthRequest(Request $request): bool
    {
        // TODO: Look for a more elegant solution to this
        $session = $request->getSession();
        $query = $request->query;

        // Prepare some local variables
        $queryClientId = $query->get('client_id');
        $queryRedirectUri = $query->get('redirect_uri');
        $queryScopes = $query->get('scopes', []);

        $sessionClientId = $session->get('client_id');

        // Check if either $_QUERY or $_SESSION has a client ID
        if (!$queryClientId && !$sessionClientId) {
            return false; // No client ID, nothing to authenticate
        }

        // If we have it in the query, proceed to setup the session
        if ($queryClientId) {
            // Store the variables in session for now, we will refer to this later in an event listener
            $session->set('client_id', $queryClientId);
            $session->set('redirect_uri', $queryRedirectUri);
            $session->set('scopes', $queryScopes);
        }

        // Fetch them for a last verification check (maybe this can be moved into the last if?)
        $sessionRedirectUri = $session->get('redirect_uri');
        $sessionScopes = $session->get('scopes', []);

        // Do a last check that we are all set to actually do something
        return !(!$sessionRedirectUri || !count($sessionScopes));
    }
}

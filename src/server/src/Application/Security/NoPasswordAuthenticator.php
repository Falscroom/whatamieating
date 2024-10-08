<?php

declare(strict_types=1);

namespace App\Application\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

final class NoPasswordAuthenticator extends AbstractLoginFormAuthenticator
{
    public function __construct(private readonly RouterInterface $router) {}

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('_username');

        return new Passport(new UserBadge($username), new CustomCredentials(fn () => true, null));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate('app_login');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('app_presentation_meal_whatamieating'));
    }
}

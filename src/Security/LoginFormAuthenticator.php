<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

// Définit une classe d'authentification pour le formulaire de connexion.
class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;  // Permet d'utiliser le trait TargetPathTrait qui fournit des méthodes pour gérer l'URL de redirection après la connexion.

    public const LOGIN_ROUTE = 'app_login'; // Définit une constante pour la route de connexion.

    public function __construct(private UrlGeneratorInterface $urlGenerator)  // Le constructeur de la classe avec une injection de dépendance pour UrlGeneratorInterface.
    {
    }

    public function authenticate(Request $request): Passport    // Cette méthode est utilisée pour authentifier l'utilisateur.
    {
        $email = $request->request->get('email', '');  // Récupère l'email de la requête.

        $request->getSession()->set(Security::LAST_USERNAME, $email);  // Enregistre le dernier nom d'utilisateur utilisé dans la session

        // Crée et renvoie un nouveau Passport pour l'utilisateur, avec l'email, le mot de passe et le token CSRF.
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }


    // Cette méthode est appelée lorsque l'authentification est réussie.
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Si un chemin cible est stocké dans la session, redirige vers ce chemin
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('app_account'));
    }

    // Cette méthode génère l'URL de la page de connexion.
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}

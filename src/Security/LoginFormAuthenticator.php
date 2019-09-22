<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function supports(Request $request)
    {
        // Checking to see if the url is /login
        return $request->attributes->get('_route') === 'app_login'
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        // get $_POST
//        dd($request->request->all());
        return [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password')
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
//        dd($credentials);
        return $this->userRepository->findOneBy(['email' => $credentials['email']]);

    }

    public function checkCredentials($credentials, UserInterface $user)
    {
//        dd($user);
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        dd('Success');
    }

    protected function getLoginUrl()
    {
        // TODO: Implement getLoginUrl() method.
    }
}

<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Security\Authentication;

use Atlance\JwtAuth\Security\UseCase\Access\Token\HandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

final class JWTAuthenticator extends AbstractGuardAuthenticator
{
    private Contracts\HeaderExtractorInterface $extractor;

    private HandlerInterface $authenticator;

    public function __construct(Contracts\HeaderExtractorInterface $extractor, HandlerInterface $authenticator)
    {
        $this->extractor = $extractor;
        $this->authenticator = $authenticator;
    }

    /** {@inheritdoc} */
    public function supports(Request $request): bool
    {
        return $this->extractor->supported($request);
    }

    /** {@inheritdoc} */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
    {
        return null;
    }

    /** {@inheritdoc} */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        throw $exception;
    }

    /** {@inheritdoc} */
    public function getCredentials(Request $request): string
    {
        return $this->extractor->extract($request);
    }

    /** {@inheritdoc} */
    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        if (null === $credentials) {
            return null;
        }

        $identifier = $this->authenticator->handle($credentials);

        return $userProvider->loadUserByUsername($identifier);
    }

    /** {@inheritdoc} */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    /** {@inheritdoc} */
    public function supportsRememberMe(): bool
    {
        return false;
    }

    /** {@inheritdoc} */
    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new Response(null, Response::HTTP_UNAUTHORIZED);
    }
}

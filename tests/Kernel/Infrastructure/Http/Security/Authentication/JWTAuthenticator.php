<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Security\Authentication;

use Atlance\JwtAuth\Security\UseCase\Access\Token\HandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class JWTAuthenticator extends AbstractAuthenticator
{
    private Contracts\HeaderExtractorInterface $extractor;

    private UserProviderInterface $provider;

    private HandlerInterface $factory;

    public function __construct(
        Contracts\HeaderExtractorInterface $extractor,
        UserProviderInterface $provider,
        HandlerInterface $factory
    ) {
        $this->extractor = $extractor;
        $this->provider = $provider;
        $this->factory = $factory;
    }

    /** {@inheritdoc} */
    public function supports(Request $request): ?bool
    {
        return $this->extractor->supported($request);
    }

    /** {@inheritdoc} */
    public function authenticate(Request $request)
    {
        return new SelfValidatingPassport(
            new UserBadge(
                $this->factory->handle($this->extractor->extract($request)),
                function (string $identifier) {
                    return $this->provider->loadUserByIdentifier($identifier);
                }
            )
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        throw $exception;
    }
}

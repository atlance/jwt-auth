<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Security\UseCase\Access\Token;

use Atlance\JwtAuth\Token\Contracts\DecodeInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

final class Handler implements AccessTokenHandlerInterface
{
    public function __construct(private readonly DecodeInterface $decoder, private readonly string $identifierClaimName)
    {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        try {
            \assert('' !== $accessToken);
            $claimset = $this->decoder->decode($accessToken);
        } catch (\Throwable $exception) {
            throw new AuthenticationException($exception->getMessage());
        }

        return new UserBadge((string) $claimset->get($this->identifierClaimName));
    }
}

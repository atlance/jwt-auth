<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Security\Factory;

use Atlance\JwtAuth\Security\UseCase\Access\Token\HandlerInterface;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

final readonly class UserBadgeFactory implements AccessTokenHandlerInterface
{
    public function __construct(private HandlerInterface $handler)
    {
    }

    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        return new UserBadge($this->handler->handle($accessToken));
    }
}

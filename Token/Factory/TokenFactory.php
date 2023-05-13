<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\Factory;

use Atlance\JwtAuth\Token\Contracts\Builder\Decorator\NullableArgsDecoratorInterface;
use Atlance\JwtAuth\Token\Contracts\Claimset\ClaimsetInterface;
use Atlance\JwtAuth\Token\Contracts\Factory\TokenFactoryInterface;
use Lcobucci\JWT;

class TokenFactory implements TokenFactoryInterface
{
    public function __construct(private readonly NullableArgsDecoratorInterface $builder)
    {
    }

    /** {@inheritdoc} */
    public function create(ClaimsetInterface $claimset, ?array $headers = null): JWT\UnencryptedToken
    {
        return $this->builder
            ->issuedBy($claimset->iss())
            ->relatedTo($claimset->sub())
            ->permittedFor(...$claimset->aud())
            ->expiresAt($claimset->exp())
            ->canOnlyBeUsedAfter($claimset->nbf())
            ->issuedAt($claimset->iat())
            ->identifiedBy($claimset->jti())
            ->withClaims($claimset->claims())
            ->withHeaders($headers)
            ->getToken();
    }
}

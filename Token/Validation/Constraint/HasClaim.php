<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\Validation\Constraint;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint as ConstraintInterface;
use Lcobucci\JWT\Validation\Constraint\CannotValidateARegisteredClaim;
use Lcobucci\JWT\Validation\ConstraintViolation;

/** @codeCoverageIgnore */
final class HasClaim implements ConstraintInterface
{
    /** @var non-empty-string */
    private readonly string $claim;

    /** @param non-empty-string $claim */
    public function __construct(string $claim)
    {
        if (\in_array($claim, Token\RegisteredClaims::ALL, true)) {
            throw CannotValidateARegisteredClaim::create($claim);
        }

        $this->claim = $claim;
    }

    public function assert(Token $token): void
    {
        if (!$token instanceof UnencryptedToken) {
            throw ConstraintViolation::error('You should pass a plain token', $this);
        }

        if (!$token->claims()->has($this->claim)) {
            throw ConstraintViolation::error('The token does not have the claim "' . $this->claim . '"', $this);
        }
    }
}

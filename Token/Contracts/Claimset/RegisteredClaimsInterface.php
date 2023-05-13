<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\Contracts\Claimset;

/**
 * @see https://datatracker.ietf.org/doc/html/rfc7519#section-4.1
 */
interface RegisteredClaimsInterface
{
    public const REGISTERED_NAMES = [
        self::ISSUER,
        self::SUBJECT,
        self::AUDIENCE,
        self::EXPIRATION_TIME,
        self::NOT_BEFORE,
        self::ISSUED_AT,
        self::ID,
    ];

    public const ISSUER = 'iss';
    public const SUBJECT = 'sub';
    public const AUDIENCE = 'aud';
    public const EXPIRATION_TIME = 'exp';
    public const NOT_BEFORE = 'nbf';
    public const ISSUED_AT = 'iat';
    public const ID = 'jti';

    /**
     * "iss" (Issuer) Claim.
     *
     * Identifies the principal that issued the JWT.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.1
     *
     * @return non-empty-string|null
     */
    public function iss(): ?string;

    /**
     * "sub" (Subject) Claim.
     *
     * Identifies the principal that is the subject of the JWT.
     *
     * https://tools.ietf.org/html/rfc7519#section-4.1.2
     *
     * @return non-empty-string|null
     */
    public function sub(): ?string;

    /**
     * "aud" (Audience) Claim.
     *
     * Identifies the recipients that the JWT is intended for.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.3
     *
     * @return iterable<int,non-empty-string>
     */
    public function aud(): iterable;

    /**
     * "exp" (Expiration Time) Claim.
     *
     * Identifies the expiration time on or after which the JWT MUST NOT be accepted for processing.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.4
     */
    public function exp(): ?\DateTimeImmutable;

    /**
     * "nbf" (Not Before) Claim.
     *
     * Identifies the time before which the JWT MUST NOT be accepted for processing.
     *
     * https://tools.ietf.org/html/rfc7519#section-4.1.5
     */
    public function nbf(): ?\DateTimeImmutable;

    /**
     * "iat" (Issued At) Claim.
     *
     * Identifies the time at which the JWT was issued.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.6
     */
    public function iat(): ?\DateTimeImmutable;

    /**
     * "jti" (JWT ID) Claim.
     *
     * Provides a unique identifier for the JWT.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.7
     *
     * @return non-empty-string|null
     */
    public function jti(): ?string;
}

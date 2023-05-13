<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\Contracts\Builder\Decorator;

use Lcobucci\JWT;

interface NullableArgsDecoratorInterface extends JWT\Builder
{
    /** {@inheritdoc} */
    public function permittedFor(string ...$audiences): self;

    /** {@inheritdoc} */
    public function expiresAt(?\DateTimeImmutable $expiration = null): self;

    /**
     * {@inheritdoc}
     *
     * @param non-empty-string|null $id
     */
    public function identifiedBy(?string $id = null): self;

    /** {@inheritdoc} */
    public function issuedAt(?\DateTimeImmutable $issuedAt = null): self;

    /**
     * {@inheritdoc}
     *
     * @param non-empty-string|null $issuer
     */
    public function issuedBy(?string $issuer = null): self;

    /** {@inheritdoc} */
    public function canOnlyBeUsedAfter(?\DateTimeImmutable $notBefore = null): self;

    /**
     * {@inheritdoc}
     *
     * @param non-empty-string|null $subject
     */
    public function relatedTo(?string $subject = null): self;

    /** {@inheritdoc} */
    public function getToken(?JWT\Signer $signer = null, ?JWT\Signer\Key $key = null): JWT\UnencryptedToken;

    /**
     * Configures a claims.
     *
     * @param non-empty-array<non-empty-string,mixed>|null $claims
     *
     * @throws JWT\Token\RegisteredClaimGiven when trying to set a registered claim
     */
    public function withClaims(?array $claims = null): self;

    /**
     * Configures a headers.
     *
     * @param non-empty-array<non-empty-string,mixed>|null $headers
     */
    public function withHeaders(?array $headers = null): self;
}

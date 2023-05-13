<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token;

use Atlance\JwtAuth\Token\Contracts\Builder\Decorator\NullableArgsDecoratorInterface;
use Lcobucci\JWT;
use Psr\Clock\ClockInterface;

final class Builder implements NullableArgsDecoratorInterface
{
    public const TTL = 1;

    public function __construct(
        private JWT\Builder $tokenBuilder,
        private readonly JWT\Signer $signer,
        private readonly JWT\Signer\Key $key,
        private readonly ClockInterface $clock,
        private readonly int $ttl = self::TTL,
    ) {
    }

    /** {@inheritdoc} */
    public function permittedFor(string ...$audiences): self
    {
        $builder = clone $this;
        $builder->tokenBuilder = $builder->tokenBuilder->permittedFor(...$audiences);

        return $builder;
    }

    /** {@inheritdoc} */
    public function expiresAt(?\DateTimeImmutable $expiration = null): self
    {
        $builder = clone $this;
        if (null === $expiration) {
            $expiration = $builder->clock->now()->setTimestamp(time() + $builder->ttl);
        }

        $builder->tokenBuilder = $builder->tokenBuilder->expiresAt($expiration);

        return $builder;
    }

    /** {@inheritdoc} */
    public function identifiedBy(?string $id = null): self
    {
        $builder = clone $this;
        if (null !== $id) {
            $builder->tokenBuilder = $builder->tokenBuilder->identifiedBy($id);
        }

        return $builder;
    }

    /** {@inheritdoc} */
    public function issuedAt(?\DateTimeImmutable $issuedAt = null): self
    {
        $builder = clone $this;
        $builder->tokenBuilder = $builder->tokenBuilder->issuedAt($issuedAt ?? $this->clock->now());

        return $builder;
    }

    /** {@inheritdoc} */
    public function issuedBy(?string $issuer = null): self
    {
        $builder = clone $this;
        if (null !== $issuer) {
            $builder->tokenBuilder = $builder->tokenBuilder->issuedBy($issuer);
        }

        return $builder;
    }

    /** {@inheritdoc} */
    public function canOnlyBeUsedAfter(?\DateTimeImmutable $notBefore = null): self
    {
        $builder = clone $this;
        $builder->tokenBuilder = $builder->tokenBuilder->canOnlyBeUsedAfter($notBefore ?? $builder->clock->now());

        return $builder;
    }

    /** {@inheritdoc} */
    public function relatedTo(?string $subject = null): self
    {
        $builder = clone $this;
        if (null !== $subject) {
            $builder->tokenBuilder = $builder->tokenBuilder->relatedTo($subject);
        }

        return $builder;
    }

    /** {@inheritdoc} */
    public function withHeader(string $name, mixed $value): self
    {
        $builder = clone $this;
        $builder->tokenBuilder = $builder->tokenBuilder->withHeader($name, $value);

        return $builder;
    }

    /** {@inheritdoc} */
    public function withHeaders(?array $headers = null): self
    {
        if (null === $headers) {
            return $this;
        }

        $builder = clone $this;
        /** @var mixed $value */
        foreach ($headers as $name => $value) {
            $builder = $builder->withHeader($name, $value);
        }

        return $builder;
    }

    /** {@inheritdoc} */
    public function withClaim(string $name, mixed $value): self
    {
        $builder = clone $this;
        $builder->tokenBuilder = $builder->tokenBuilder->withClaim($name, $value);

        return $builder;
    }

    /** {@inheritdoc} */
    public function withClaims(?array $claims = null): self
    {
        if (null === $claims) {
            return $this;
        }

        $builder = clone $this;
        /** @var mixed $value */
        foreach ($claims as $name => $value) {
            $builder = $builder->withClaim($name, $value);
        }

        return $builder;
    }

    /** {@inheritdoc} */
    public function getToken(?JWT\Signer $signer = null, ?JWT\Signer\Key $key = null): JWT\UnencryptedToken
    {
        $builder = clone $this;

        return $builder->tokenBuilder->getToken($signer ?? $this->signer, $key ?? $this->key);
    }
}

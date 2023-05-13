<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token;

use Atlance\JwtAuth\Token\Contracts\Claimset\ClaimsetInterface;

/**
 * @psalm-suppress MixedInferredReturnType
 * @psalm-suppress MixedReturnStatement
 */
class Claimset implements ClaimsetInterface
{
    public function __construct(
        /** @var non-empty-array<non-empty-string,mixed> */
        private readonly array $hashtable
    ) {
    }

    /** {@inheritdoc} */
    public function iss(): ?string
    {
        return $this->get(self::ISSUER);
    }

    /** {@inheritdoc} */
    public function sub(): ?string
    {
        return $this->get(self::SUBJECT);
    }

    /** {@inheritdoc} */
    public function aud(): iterable
    {
        return $this->get(self::AUDIENCE, []);
    }

    /** {@inheritdoc} */
    public function exp(): ?\DateTimeImmutable
    {
        return $this->get(self::EXPIRATION_TIME);
    }

    /** {@inheritdoc} */
    public function nbf(): ?\DateTimeImmutable
    {
        return $this->get(self::NOT_BEFORE);
    }

    /** {@inheritdoc} */
    public function iat(): ?\DateTimeImmutable
    {
        return $this->get(self::ISSUED_AT);
    }

    /** {@inheritdoc} */
    public function jti(): ?string
    {
        return $this->get(self::ID);
    }

    /**
     * @psalm-suppress MixedAssignment
     *
     * {@inheritdoc}
     */
    public function claims(): ?array
    {
        $claims = [];
        foreach ($this->hashtable as $name => $value) {
            if (!\in_array($name, self::REGISTERED_NAMES, true)) {
                $claims[$name] = $value;
            }
        }

        return [] === $claims ? null : $claims;
    }

    /** {@inheritdoc} */
    public function get(string $name, mixed $default = null): mixed
    {
        return $this->hashtable[$name] ?? $default;
    }

    /** {@inheritdoc} */
    public function has(string $name): bool
    {
        return \array_key_exists($name, $this->hashtable);
    }

    /** {@inheritdoc} */
    public function all(): array
    {
        return $this->hashtable;
    }
}

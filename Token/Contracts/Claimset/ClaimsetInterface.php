<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\Contracts\Claimset;

/**
 * Claimset is a container for registered and custom JWT claims.
 */
interface ClaimsetInterface extends RegisteredClaimsInterface
{
    /**
     * Unregistered claims as associative array (MUST NOT contain registered names).
     *
     * @return non-empty-array<non-empty-string,mixed>|null
     */
    public function claims(): ?array;

    public function get(string $name, mixed $default = null): mixed;

    public function has(string $name): bool;

    /** @return non-empty-array<non-empty-string,mixed> */
    public function all(): array;
}

<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\Contracts\Factory;

use Atlance\JwtAuth\Token\Contracts\Claimset\ClaimsetInterface;
use Lcobucci\JWT;

interface TokenFactoryInterface
{
    /**
     * @param non-empty-array<non-empty-string,mixed>|null $headers
     */
    public function create(ClaimsetInterface $claimset, ?array $headers = null): JWT\UnencryptedToken;
}

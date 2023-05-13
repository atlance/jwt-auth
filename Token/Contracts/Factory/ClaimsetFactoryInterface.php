<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\Contracts\Factory;

use Atlance\JwtAuth\Token\Contracts\Claimset\ClaimsetInterface;

interface ClaimsetFactoryInterface
{
    /** @param non-empty-array<non-empty-string,mixed> $dataset */
    public static function create(array $dataset): ClaimsetInterface;
}

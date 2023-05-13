<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\Factory;

use Atlance\JwtAuth\Token\Claimset;
use Atlance\JwtAuth\Token\Contracts\Claimset\ClaimsetInterface;
use Atlance\JwtAuth\Token\Contracts\Factory\ClaimsetFactoryInterface;

class ClaimsetFactory implements ClaimsetFactoryInterface
{
    /** @param non-empty-array<non-empty-string,mixed> $dataset */
    public static function create(array $dataset): ClaimsetInterface
    {
        return new Claimset($dataset);
    }
}

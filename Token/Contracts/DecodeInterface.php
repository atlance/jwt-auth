<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\Contracts;

use Atlance\JwtAuth\Token\Contracts\Claimset\ClaimsetInterface;

interface DecodeInterface
{
    /** @param non-empty-string $value */
    public function decode(string $value): ClaimsetInterface;
}

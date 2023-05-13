<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\Contracts;

use Atlance\JwtAuth\Token\Contracts\Claimset\ClaimsetInterface;

interface EncodeInterface
{
    public function encode(ClaimsetInterface $claimset): string;
}

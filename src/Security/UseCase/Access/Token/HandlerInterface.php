<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Security\UseCase\Access\Token;

interface HandlerInterface
{
    public function handle(string $accessToken): string;
}

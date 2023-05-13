<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Security\Authentication\Contracts;

use Symfony\Component\HttpFoundation\Request;

interface HeaderExtractorInterface
{
    public function supported(Request $request): bool;

    public function extract(Request $request): string;
}

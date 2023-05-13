<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller;

use Lcobucci\JWT\Encoding\JoseEncoder;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController
{
    protected function jsonDecode(Request $request): array
    {
        return (new JoseEncoder())->jsonDecode((string) $request->getContent());
    }
}

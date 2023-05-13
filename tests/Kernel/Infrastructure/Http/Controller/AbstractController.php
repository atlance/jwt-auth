<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller;

use Atlance\JwtAuth\Tests\Kernel\Domain\Utils\Json\Encoder\JoseEncoder;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController
{
    protected function jsonDecode(Request $request): array
    {
        return JoseEncoder::jsonDecode((string) $request->getContent());
    }
}

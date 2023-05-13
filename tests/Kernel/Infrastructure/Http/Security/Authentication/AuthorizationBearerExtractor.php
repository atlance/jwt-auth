<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Security\Authentication;

use Symfony\Component\HttpFoundation\Request;

final class AuthorizationBearerExtractor implements Contracts\HeaderExtractorInterface
{
    private const HEADER = 'Authorization';

    public function supported(Request $request): bool
    {
        return $request->headers->has(self::HEADER)
            && str_starts_with($request->headers->get(self::HEADER), 'Bearer ');
    }

    public function extract(Request $request): string
    {
        // token without `Bearer `
        return mb_substr($request->headers->get(self::HEADER), 7);
    }
}

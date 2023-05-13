<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel\Domain\Utils\Json\Encoder;

final class JoseEncoder
{
    public static function jsonEncode($data): string
    {
        try {
            return json_encode($data, \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR);
        } catch (\JsonException $jsonException) {
            throw new \RuntimeException('Error while encoding to JSON', $jsonException->getCode(), $jsonException);
        }
    }

    public static function jsonDecode(string $json)
    {
        try {
            return json_decode($json, true, \JSON_THROW_ON_ERROR, \JSON_THROW_ON_ERROR);
        } catch (\JsonException $jsonException) {
            throw new \RuntimeException('Error while decoding from JSON', $jsonException->getCode(), $jsonException);
        }
    }
}

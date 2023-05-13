<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Utils\Dto;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

final class Response
{
    public int $code;

    public string $type;

    public array $content = [];

    public ResponseHeaderBag $headers;

    /** @param array<string, mixed> $properties */
    public function __construct(array $properties = [])
    {
        /** @psalm-var mixed $value */
        foreach ($properties as $property => $value) {
            if (\is_string($value) && '' === $value = trim($value)) {
                continue;
            }

            if ([] === $value || null === $value) {
                continue;
            }

            $method = 'set' . ucfirst($property);
            if (\is_callable([$this, $method])) {
                $this->{$method}($value); /* @phpstan-ignore-line */

                continue;
            }

            if (property_exists(self::class, $property)) {
                $this->{$property} = $value; /* @phpstan-ignore-line */
            }
        }
    }

    public function setContent($content): void
    {
        if (!\is_array($content)) {
            $content = [$content];
        }

        $this->content = $content;
    }
}

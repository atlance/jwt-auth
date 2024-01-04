<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Security\UseCase\Access\Token;

use Atlance\JwtCore\Token\Contracts\DecodeInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

final readonly class Handler implements HandlerInterface
{
    public function __construct(private DecodeInterface $decoder, private string $identifierClaimName)
    {
    }

    public function handle(string $accessToken): string
    {
        try {
            \assert('' !== $accessToken);
            $dataSet = $this->decoder->decode($accessToken);
        } catch (\Throwable $throwable) {
            throw new AuthenticationException($throwable->getMessage(), 0, $throwable);
        }

        $userIdentifier = $dataSet->get($this->identifierClaimName);
        if (!\is_string($userIdentifier) && !\is_int($userIdentifier)) {
            throw new \UnexpectedValueException('Incorrect identity value');
        }

        return (string) $userIdentifier;
    }
}

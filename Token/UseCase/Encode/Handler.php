<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\UseCase\Encode;

use Atlance\JwtAuth\Token\Contracts\Claimset\ClaimsetInterface;
use Atlance\JwtAuth\Token\Contracts\EncodeInterface;
use Atlance\JwtAuth\Token\Contracts\Factory\TokenFactoryInterface;
use Atlance\JwtAuth\Token\Validation\Validator;

final class Handler implements EncodeInterface
{
    public function __construct(
        private readonly TokenFactoryInterface $factory,
        private readonly Validator $validator
    ) {
    }

    public function encode(ClaimsetInterface $claimset): string
    {
        $token = $this->factory->create($claimset);
        $this->validator->assert($token);

        return $token->toString();
    }
}

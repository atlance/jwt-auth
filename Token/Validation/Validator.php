<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\Validation;

use Lcobucci\JWT;

final class Validator
{
    public function __construct(
        private readonly JWT\Validator $validator,
        /** @var array<int, JWT\Validation\Constraint> */
        private readonly array $constraints,
    ) {
    }

    public function assert(JWT\UnencryptedToken $token): void
    {
        $this->validator->assert($token, ...$this->constraints);
    }
}

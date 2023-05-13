<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Token\UseCase\Decode;

use Atlance\JwtAuth\Token\Contracts\Claimset\ClaimsetInterface;
use Atlance\JwtAuth\Token\Contracts\DecodeInterface;
use Atlance\JwtAuth\Token\Factory\ClaimsetFactory;
use Atlance\JwtAuth\Token\Validation\Validator;
use Lcobucci\JWT;

final class Handler implements DecodeInterface
{
    public function __construct(private readonly JWT\Parser $parser, private readonly Validator $validator)
    {
    }

    /**
     * @psalm-suppress ArgumentTypeCoercion
     *
     * @param non-empty-string $value
     *
     * @throws JWT\Encoding\CannotDecodeContent           when something goes wrong while decoding
     * @throws JWT\Token\InvalidTokenStructure            when token string structure is invalid
     * @throws JWT\Token\UnsupportedHeaderFound           when parsed token has an unsupported header
     * @throws JWT\Validation\RequiredConstraintsViolated
     * @throws JWT\Validation\NoConstraintsGiven
     */
    public function decode(string $value): ClaimsetInterface
    {
        $token = $this->parser->parse($value);
        \assert($token instanceof JWT\UnencryptedToken);

        $this->validator->assert($token);

        return ClaimsetFactory::create($token->claims()->all()); // @phpstan-ignore-line
    }
}

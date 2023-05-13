<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\DependencyInjection;

use Lcobucci\JWT\Signer as SignerInterface;
use Lcobucci\JWT\Signer\Blake2b;
use Lcobucci\JWT\Signer\Ecdsa;
use Lcobucci\JWT\Signer\Eddsa;
use Lcobucci\JWT\Signer\Hmac;
use Lcobucci\JWT\Signer\Rsa;

/**
 * @see https://lcobucci-jwt.readthedocs.io/en/stable/supported-algorithms/
 */
class SignerClassResolver
{
    // Asymmetric algorithms
    public const ES256 = 'ES256';
    public const ES384 = 'ES384';
    public const ES512 = 'ES512';
    public const RS256 = 'RS256';
    public const RS384 = 'RS384';
    public const RS512 = 'RS512';
    public const EDDSA = 'EDDSA';
    // Symmetric algorithms
    public const HS256 = 'HS256';
    public const HS384 = 'HS384';
    public const HS512 = 'HS512';
    public const BLAKE2B = 'BLAKE2B';

    public const ALGORITHM_MAP = [
        self::ES256 => Ecdsa\Sha256::class,
        self::ES384 => Ecdsa\Sha384::class,
        self::ES512 => Ecdsa\Sha512::class,
        self::RS256 => Rsa\Sha256::class,
        self::RS384 => Rsa\Sha384::class,
        self::RS512 => Rsa\Sha512::class,
        self::EDDSA => Eddsa::class,
        self::HS256 => Hmac\Sha256::class,
        self::HS384 => Hmac\Sha384::class,
        self::HS512 => Hmac\Sha512::class,
        self::BLAKE2B => Blake2b::class,
    ];

    public static function resolve(string $algorithmId): SignerInterface
    {
        $algorithmId = mb_strtoupper($algorithmId);

        if (null === $className = self::ALGORITHM_MAP[$algorithmId] ?? null) {
            throw new \InvalidArgumentException(sprintf('algorithm: "%s" - is not supported.', $algorithmId));
        }

        return new $className();
    }
}

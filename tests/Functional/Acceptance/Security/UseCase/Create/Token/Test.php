<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Functional\Acceptance\Security\UseCase\Create\Token;

use Atlance\JwtAuth\Tests\Functional\Acceptance\TestCase;
use Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller\Login\Controller;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;

/** @see Controller */
class Test extends TestCase
{
    /** @param array{username:string,password:string} $credentials */
    #[DataProvider('dataset')]
    public function test(array $credentials, int $expectCode): void
    {
        $response = $this->requester()
            ->post(Controller::class, content: $credentials, expectCode: $expectCode);

        if (Response::HTTP_OK === $expectCode) {
            self::assertArrayHasKey('token', $response->content);
        }
    }

    public static function dataset(): \Generator
    {
        yield [self::credentials(), Response::HTTP_OK];
        yield [self::credentials(true), Response::HTTP_BAD_REQUEST];
    }
}

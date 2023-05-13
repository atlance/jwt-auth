<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Functional\Acceptance\Security\UseCase\Access\Token;

use Atlance\JwtAuth\Tests\Functional\Acceptance\TestCase;
use Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller\Login\Controller as LoginController;
use Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller\Profile\Controller as ProfileController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @see LoginController
 * @see ProfileController
 */
class Test extends TestCase
{
    public function testOk(): void
    {
        $response = $this->requester()->post(LoginController::class, content: $this->credentials());
        self::assertArrayHasKey('token', $response->content);
        $token = $response->content['token'];

        $response = $this->requester()->get(ProfileController::class, headers: [
            'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token),
        ]);

        self::assertEquals(['username' => self::USERNAME], $response->content);
    }

    public function testBadToken(): void
    {
        $this->requester()->get(
            ProfileController::class,
            expectCode: Response::HTTP_FOUND,
            headers: [
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $this->dg()->text()),
            ]
        );
    }

    public function testExpiredToken(): void
    {
        $this->requester()->get(
            ProfileController::class,
            expectCode: Response::HTTP_UNAUTHORIZED,
            headers: [
                'HTTP_AUTHORIZATION' => sprintf(
                    'Bearer %s',// phpcs:disable
                    <<<TXT
                        eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2ODM5NjA4NTEsIm5iZiI6MTY4Mzk2MDg1MC40MTc3NDMsImlhdCI6MTY4Mzk2MDg1MC40MTc3NDYsImNsaWVudF9pZCI6InN1cGVyX2FkbWluIiwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfU1VQRVJfQURNSU4iXX0.qSwtynpdIg0KmN6vWi2FOW32cS0spzcehlqlDTWe1sc
                    TXT
                ), // phpcs:enable
            ]
        );
    }
}

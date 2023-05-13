<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Functional\Acceptance;

use Atlance\JwtAuth\Tests\Functional\KernelTestCase;
use Atlance\JwtAuth\Tests\Utils\Requester;

class TestCase extends KernelTestCase
{
    public const USERNAME = 'super_admin';

    private ?Requester $requester = null;

    final public function requester(): Requester
    {
        if (!$this->requester instanceof Requester) {
            throw new \UnexpectedValueException(sprintf('Expected %s', Requester::class));
        }

        return $this->requester;
    }

    /** @return array{username:string,password:string} */
    public static function credentials(bool $isRandom = false): array
    {
        return [
            'username' => $isRandom ? self::dg()->userName() : self::USERNAME,
            'password' => $isRandom ? self::dg()->password() : getenv('APP_SECRET'),
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->requester = new Requester($this->service('test.client'), $this->service('router'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->requester = null;
    }
}

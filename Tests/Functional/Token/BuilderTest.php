<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Functional\Token;

use Atlance\JwtAuth\Tests\Functional\KernelTestCase;
use Atlance\JwtAuth\Token\Contracts\Claimset\RegisteredClaimsInterface as C;
use Atlance\JwtAuth\Token\Contracts\Factory\TokenFactoryInterface;
use Atlance\JwtAuth\Token\Factory\ClaimsetFactory;

class BuilderTest extends KernelTestCase
{
    private ?TokenFactoryInterface $factory = null;

    public function testBuild()
    {
        $claimset = ClaimsetFactory::create([
            C::ISSUER => 'a',
            C::SUBJECT => 'b',
            C::AUDIENCE => ['c', 'd'],
            C::EXPIRATION_TIME => new \DateTimeImmutable(),
            C::NOT_BEFORE => new \DateTimeImmutable(),
            C::ISSUED_AT => new \DateTimeImmutable(),
            C::ID => self::dg()->uuid(),
        ]);

        self::assertFalse($claimset->has('foo'));

        self::assertEquals(
            $claimset->all(),
            $this->factory->create($claimset, ['header_1' => 1])->claims()->all()
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = $this->service(TokenFactoryInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->factory = null;
    }
}

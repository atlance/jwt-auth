<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Security\UseCase\Create\Token;

use Atlance\JwtAuth\Security\Factory\Contracts\UserClaimsetFactoryInterface;
use Atlance\JwtAuth\Token\Contracts\EncodeInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class Handler
{
    public function __construct(
        private readonly UserClaimsetFactoryInterface $factory,
        private readonly EncodeInterface $encoder,
    ) {
    }

    public function handle(UserInterface $user): string
    {
        return $this->encoder->encode($this->factory->create($user));
    }
}

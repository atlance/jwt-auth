<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Security\UseCase\Create\Token;

use Atlance\JwtAuth\Security\Factory\Contracts\UserDataSetFactoryInterface;
use Atlance\JwtCore\Token\Contracts\EncodeInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class Handler implements HandlerInterface
{
    public function __construct(private UserDataSetFactoryInterface $factory, private EncodeInterface $encoder)
    {
    }

    public function handle(UserInterface $user): string
    {
        return $this->encoder->encode($this->factory->create($user));
    }
}

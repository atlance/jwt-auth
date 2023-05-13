<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Security\UseCase\Create\Token;

use Symfony\Component\Security\Core\User\UserInterface;

interface HandlerInterface
{
    public function handle(UserInterface $user): string;
}

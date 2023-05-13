<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Security\Factory\Contracts;

use Atlance\JwtAuth\Token\Contracts\Claimset\ClaimsetInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserClaimsetFactoryInterface
{
    public function create(UserInterface $user): ClaimsetInterface;
}

<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Security\Factory;

use Atlance\JwtAuth\Security\Factory\Contracts\UserClaimsetFactoryInterface;
use Atlance\JwtAuth\Token\Contracts\Claimset\ClaimsetInterface;
use Atlance\JwtAuth\Token\Factory\ClaimsetFactory;
use Symfony\Component\Security\Core\User\UserInterface;

class UserClaimsetFactory implements UserClaimsetFactoryInterface
{
    public function __construct(
        /** @var non-empty-string $identifierClaimName */
        private readonly string $identifierClaimName
    ) {
    }

    public function create(UserInterface $user): ClaimsetInterface
    {
        return ClaimsetFactory::create([
            $this->identifierClaimName => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
        ]);
    }
}

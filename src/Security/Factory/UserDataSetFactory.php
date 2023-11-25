<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Security\Factory;

use Atlance\JwtAuth\Security\Factory\Contracts\UserDataSetFactoryInterface;
use Atlance\JwtCore\Token\Contracts\DataSet\DataSetInterface;
use Atlance\JwtCore\Token\Factory\DataSetFactory;
use Symfony\Component\Security\Core\User\UserInterface;

class UserDataSetFactory implements UserDataSetFactoryInterface
{
    /**
     * @param non-empty-string $identifierClaimName
     */
    public function __construct(private readonly string $identifierClaimName)
    {
    }

    /** @psalm-suppress DeprecatedClass */
    public function create(UserInterface $user): DataSetInterface
    {
        return DataSetFactory::fromHashTable([
            $this->identifierClaimName => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
        ]);
    }
}

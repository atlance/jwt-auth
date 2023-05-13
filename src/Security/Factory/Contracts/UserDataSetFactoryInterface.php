<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Security\Factory\Contracts;

use Atlance\JwtCore\Token\Contracts\DataSet\DataSetInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserDataSetFactoryInterface
{
    public function create(UserInterface $user): DataSetInterface;
}

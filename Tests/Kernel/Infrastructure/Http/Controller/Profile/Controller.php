<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller\Profile;

use Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/profile', name: self::class, methods: ['GET'])]
class Controller extends AbstractController
{
    public function __invoke(#[CurrentUser] ?UserInterface $user = null): JsonResponse
    {
        return new JsonResponse(['username' => $user->getUserIdentifier()]);
    }
}

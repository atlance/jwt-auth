<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/profile', methods: ['GET'])]
final class Controller extends AbstractController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['username' => $this->getUser()->getUserIdentifier()]);
    }
}

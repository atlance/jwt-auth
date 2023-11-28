<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller\Profile;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 *
 * @Route("/profile", name=Controller::class, methods={"GET"})
 */
class Controller extends AbstractController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['username' => $this->getUser()->getUserIdentifier()]);
    }
}

<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller\Login;

use Atlance\JwtAuth\Security\UseCase;
use Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

#[Route('/login', methods: ['POST'])]
final class Controller extends AbstractController
{
    public function __invoke(
        Request $request,
        UserProviderInterface $provider,
        UserPasswordHasherInterface $hasher,
        UseCase\Create\Token\HandlerInterface $handler
    ): JsonResponse {
        /** @var array{username:string,password:string} $dataSet */
        $dataSet = $this->jsonDecode($request);

        try {
            $user = $provider->loadUserByIdentifier($dataSet['username']);
            $hasher->isPasswordValid($user, $hasher->hashPassword($user, $dataSet['password']));

            return new JsonResponse(['token' => $handler->handle($user)]);
        } catch (UserNotFoundException) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }
    }
}

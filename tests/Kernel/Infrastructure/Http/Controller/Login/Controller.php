<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller\Login;

use Atlance\JwtAuth\Security\UseCase;
use Atlance\JwtAuth\Tests\Kernel\Infrastructure\Http\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
 * @Route("/login", name=Controller::class, methods={"POST"})
 */
final class Controller extends AbstractController
{
    public function __invoke(
        Request $request,
        UserProviderInterface $provider,
        UserPasswordEncoderInterface $encoder,
        UseCase\Create\Token\HandlerInterface $handler
    ): JsonResponse {
        /** @var array{username:string,password:string} $dataset */
        $dataset = $this->jsonDecode($request);

        try {
            $user = $provider->loadUserByUsername($dataset['username']);
            $encoder->isPasswordValid($user, $encoder->encodePassword($user, $dataset['password']));

            return new JsonResponse(['token' => $handler->handle($user)]);
        } catch (UsernameNotFoundException $usernameNotFoundException) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }
    }
}

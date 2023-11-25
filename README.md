Symfony 6: JWT Authentication
==============
[![composer.lock](http://poser.pugx.org/phpunit/phpunit/composerlock)](https://packagist.org/packages/phpunit/phpunit)
[![PHP analyze & tests](https://github.com/atlance/jwt-auth/actions/workflows/php-analyze.yml/badge.svg)](https://github.com/atlance/jwt-auth/actions/workflows/php-analyze.yml)
![Psalm level](https://shepherd.dev/github/atlance/jwt-auth/level.svg)
![Psalm coverage](https://shepherd.dev/github/atlance/jwt-auth/coverage.svg)
![GitHub](https://img.shields.io/badge/PHPStan-level%20max-brightgreen.svg?style=flat)
[![codecov](https://codecov.io/gh/atlance/jwt-auth/graph/badge.svg?token=EV9EVMTRTL)](https://codecov.io/gh/atlance/jwt-auth)

## Installation

1. <a href="/docs/generate_keys.md" target="_blank">Generate</a> keys.
2. Install package via composer: `composer require atlance/jwt-auth ^6.0`.
3. Configure:
   - Copy/paste <a href="/src/Resources/config/atlance_jwt_auth.yaml" target="_blank">configuration</a> to 
     `config/packages/atlance_jwt_auth.yaml`.
   - Copy/paste <a href="/.env.dist" target="_blank">environments</a> to your `.env` and configure.

## Use Case

### Create:
- **Implemened:** `Atlance\JwtAuth\Security\UseCase\Create\Token\Handler`.
- **Example**:
```php
<?php

declare(strict_types=1);

namespace App\Controller\Login;

use Atlance\JwtAuth\Security\UseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        UseCase\Create\Token\HandlerInterface $handler,
    ): JsonResponse {
        /** @var array{username:string,password:string} $dataset */
        $dataset = json_decode($request->getContent(), true);

        try {
            $user = $provider->loadUserByIdentifier($dataset['username']);
            $hasher->isPasswordValid($user, $hasher->hashPassword($user, $dataset['password']));

            return new JsonResponse(['token' => $handler->handle($user)]);
        } catch (UserNotFoundException) {
            return new JsonResponse(status: Response::HTTP_BAD_REQUEST);
        }
    }
}
```

### Access:
**Implemened:**
- `Atlance\JwtAuth\Security\UseCase\Access\Token\Handler`
- `Atlance\JwtAuth\Security\Factory\UserBadgeFactory`

```yaml
# config/packages/security.yaml
security:
    firewalls:
        main:
            access_token:
                token_handler: Atlance\JwtAuth\Security\Factory\UserBadgeFactory
```
- **And Symfony automatically used JWT for authentication**.
- **More:** <a href="https://symfony.com/doc/6.2/security/access_token.html" target="_blank">How to use Access Token Authentication</a>.
- **Example**:
```php
<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/profile', methods: ['GET'])]
class ProfileController extends AbstractController
{
    public function __invoke(#[CurrentUser] ?UserInterface $user = null): JsonResponse
    {
        return new JsonResponse(['username' => $user->getUserIdentifier()]);
    }
}
```

Resources
---------
* [component symfony/security](https://github.com/symfony/security-bundle/tree/6.2)
* [component symfony/clock](https://github.com/symfony/clock/tree/6.2)
* [decorator of lcobucci/jwt](https://github.com/atlance/jwt-core)

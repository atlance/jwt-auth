<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel;

use Symfony\Component\DependencyInjection\ContainerInterface;

final class ContainerFactory
{
    public function create(string $environment, bool $debug): ContainerInterface
    {
        $kernel = new Kernel($environment, $debug);
        $kernel->boot();

        return $kernel->getContainer();
    }
}

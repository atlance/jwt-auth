<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Kernel;

use Atlance\JwtAuth\AtlanceJwtAuthBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
        yield new SecurityBundle();
        yield new SensioFrameworkExtraBundle();
        yield new AtlanceJwtAuthBundle();
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }

    public function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $configDir = $this->getConfigDir();

        $loader->load($configDir . '/packages/*.{php,yaml}', 'glob');
        $loader->load($configDir . '/services.{php,yaml}', 'glob');

        if (is_file($configDir . '/services_' . $this->environment . '.yaml')) {
            $loader->load($configDir . '/services_' . $this->environment . '.yaml', 'glob');
        }

        if (is_dir($configDir . '/packages/' . $this->environment)) {
            $loader->load($configDir . '/packages/' . $this->environment . '/**/*.{php,yaml}', 'glob');
        }
    }

    public function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $configDir = $this->getConfigDir();

        if (is_dir($configDir . '/routes')) {
            $routes->import($configDir . '/routes/*.{php,yaml}');
        }

        if (is_dir($configDir . '/routes/' . $this->environment)) {
            $routes->import($configDir . '/routes/' . $this->environment . '/**/*.{php,yaml}');
        }

        if (is_file($configDir . '/routes.yaml')) {
            $routes->import($configDir . '/routes.yaml');
        } else {
            $routes->import($configDir . '/routes.php');
        }
    }

    private function getConfigDir(): string
    {
        return __DIR__ . '/Resources/config';
    }
}

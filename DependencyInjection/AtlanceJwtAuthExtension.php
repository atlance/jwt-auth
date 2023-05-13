<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AtlanceJwtAuthExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        /**
         * Configuration schema.
         *
         * @var array{
         *     openssl:array{
         *         algorithm_id:string,
         *         public_key:string,
         *         private_key:string,
         *         private_passphrase:string
         *     },
         *     jwt:array{
         *         claims:array{
         *             client_claim_name:string
         *         },
         *         options:array{
         *             ttl:int
         *         }
         *     }
         * } $cfg
         */
        $cfg = $this->processConfiguration(new Configuration(), $configs);

        // openssl keys parameters
        $container->setParameter('atlance_jwt_auth.algorithm_id', $cfg['openssl']['algorithm_id']);
        $container->setParameter('atlance_jwt_auth.public_key', $cfg['openssl']['public_key']);
        $container->setParameter('atlance_jwt_auth.private_key', $cfg['openssl']['private_key']);
        $container->setParameter('atlance_jwt_auth.private_passphrase', $cfg['openssl']['private_passphrase']);
        // jwt parameters
        $container->setParameter('atlance_jwt_auth.client_claim_name', $cfg['jwt']['claims']['client_claim_name']);
        $container->setParameter('atlance_jwt_auth.ttl', $cfg['jwt']['options']['ttl']);

        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.yaml');
    }
}

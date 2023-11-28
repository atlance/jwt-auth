<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @psalm-suppress MixedMethodCall
 * @psalm-suppress PossiblyUndefinedMethod
 * @psalm-suppress UndefinedMethod
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $tb = new TreeBuilder('atlance_jwt_auth');

        $tb->getRootNode()
            ->children()
                ->arrayNode('openssl')
                    ->info('All about `openssl` keys.')
                    ->children()
                        ->scalarNode('algorithm_id')
                            ->info('Signature algorithm. `HS256`, `HS384`, `EDDSA` etc.')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('public_key')
                            ->info('The path to `public.pem`.')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('private_key')
                            ->info('The path to `private.pem`.')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('private_passphrase')
                            ->info('The pass phrase for `private.pem`.')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('jwt')
                    ->info('JWT configuration.')
                    ->children()
                        ->arrayNode('claims')
                            ->children()
                                ->scalarNode('client_claim_name')
                                    ->info('Unique identifier for current client.')
                                    ->defaultValue('client')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('options')
                            ->children()
                                ->integerNode('ttl')
                                    ->info('The expiration time in seconds.')
                                    ->defaultValue(3600)
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $tb;
    }
}

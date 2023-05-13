<?php

declare(strict_types=1);

$curDir = dirname(__DIR__);
$finder = (new PhpCsFixer\Finder())
    ->in([
        $curDir . '/src',
        $curDir . '/tests',
    ])
    ->exclude([
        'var',
    ])
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setCacheFile('var/phpcs-fixer.cache')
    ->setRules([
        '@PSR12' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'linebreak_after_opening_tag' => true,
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'mb_str_functions' => true,
        'compact_nullable_typehint' => true,
        'no_trailing_whitespace' => true,
        'types_spaces' => ['space' => 'single'],
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'phpdoc_inline_tag_normalizer' => false,
        'phpdoc_no_useless_inheritdoc' => false,
        'return_type_declaration' => ['space_before' => 'none'],
        'no_superfluous_phpdoc_tags' => ['allow_mixed' => true, 'allow_unused_params' => true],
        'phpdoc_align' => ['align' => 'vertical'],
        'ordered_class_elements' => [
            'order' => [
                'use_trait', 'public', 'protected', 'private', 'constant', 'constant_public', 'constant_protected', 'constant_private', 'property', 'property_static', 'property_public', 'property_protected', 'property_private', 'property_public_static', 'property_protected_static', 'property_private_static', 'construct', 'method', 'method_static', 'method_public', 'method_protected', 'method_private', 'method_public_static', 'method_protected_static', 'method_private_static', 'destruct', 'magic', 'phpunit',
            ],
        ],
    ])
    ->setFinder($finder)
;

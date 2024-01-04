<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php81\Rector\ClassMethod\NewInInitializerRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

// @see https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md
return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->bootstrapFiles([ 'vendor/autoload.php']);
    $rectorConfig->phpVersion(PhpVersion::PHP_82);
    $rectorConfig->phpstanConfig('vendor/phpstan/phpstan-strict-rules/rules.neon');
    $rectorConfig->phpstanConfig('config/phpstan.neon.dist');

    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,
        SetList::CODING_STYLE,
        LevelSetList::UP_TO_PHP_82,
    ]);

    $rectorConfig->paths(['src', 'tests']);

    $rectorConfig->skip([
        'vendor',
        'var',
        ClassPropertyAssignToConstructorPromotionRector::class,
        NewInInitializerRector::class,
        RenameClassRector::class,
    ]);

    $rectorConfig->parallel();
};

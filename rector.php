<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\PHPUnit\Set\PHPUnitSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withSkip([
        /**
         * not sure whether we want to automatically create documentation (e.g. via
         * phpdocumentor) or not.  Leave the tags in for now.
         */
        RemoveUselessParamTagRector::class,
        RemoveUselessReturnTagRector::class,
        /**
         * do not try to 'fix' this file. Rector is treating phpdoc types
         * as certain and I don't want that
         */
        __DIR__.'/src/numeric/FrmtrFloat.php',

    ])
    ->withPhpSets(php84: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
    )
    ->withSets(
        [
            PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
        ]
    );


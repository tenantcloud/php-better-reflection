<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

/**
 * this file is used by maintainers of the library to re-generate the type definitions
 * of webmozart/assert: you probably don't need to use it.
 */
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Bin\MixinGenerator;
require_once __DIR__ . '/../vendor/autoload.php';
\file_put_contents(__DIR__ . '/../src/Mixin.php', (new \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Bin\MixinGenerator())->generate());

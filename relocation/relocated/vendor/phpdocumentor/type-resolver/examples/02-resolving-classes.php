<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver;
require '../vendor/autoload.php';
$typeResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
// Will use the namespace and aliases to resolve to \phpDocumentor\Types\Resolver|Mockery\MockInterface
$context = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('\\phpDocumentor', ['m' => 'Mockery']);
\var_dump((string) $typeResolver->resolve('TenantCloud\\BetterReflection\\Relocated\\Types\\Resolver|m\\MockInterface', $context));

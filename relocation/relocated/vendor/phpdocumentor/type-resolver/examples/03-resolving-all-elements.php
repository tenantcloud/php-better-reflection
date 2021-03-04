<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\FqsenResolver;
require '../vendor/autoload.php';
$fqsenResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\FqsenResolver();
// Will use the namespace and aliases to resolve to a Fqsen object
$context = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Types');
// Method named: \phpDocumentor\Types\Types\Resolver::resolveFqsen()
\var_dump((string) $fqsenResolver->resolve('Types\\Resolver::resolveFqsen()', $context));
// Property named: \phpDocumentor\Types\Types\Resolver::$keyWords
\var_dump((string) $fqsenResolver->resolve('Types\\Resolver::$keyWords', $context));

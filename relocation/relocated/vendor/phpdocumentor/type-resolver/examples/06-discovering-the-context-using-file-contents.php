<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\FqsenResolver;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory;
require '../vendor/autoload.php';
$typeResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
$fqsenResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\FqsenResolver();
$contextFactory = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory();
$context = $contextFactory->createForNamespace('TenantCloud\\BetterReflection\\Relocated\\My\\Example', \file_get_contents('Classy.php'));
// Class named: \phpDocumentor\Reflection\Types\Resolver
\var_dump((string) $typeResolver->resolve('TenantCloud\\BetterReflection\\Relocated\\Types\\Resolver', $context));
// String
\var_dump((string) $typeResolver->resolve('string', $context));
// Property named: \phpDocumentor\Reflection\Types\Resolver::$keyWords
\var_dump((string) $fqsenResolver->resolve('Types\\Resolver::$keyWords', $context));

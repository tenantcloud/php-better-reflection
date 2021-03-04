<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\FqsenResolver;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory;
require '../vendor/autoload.php';
require 'Classy.php';
$typeResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
$fqsenResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\FqsenResolver();
$contextFactory = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory();
$context = $contextFactory->createFromReflector(new \ReflectionClass('TenantCloud\\BetterReflection\\Relocated\\My\\Example\\Classy'));
// Class named: \phpDocumentor\Reflection\Types\Resolver
\var_dump((string) $typeResolver->resolve('TenantCloud\\BetterReflection\\Relocated\\Types\\Resolver', $context));
// String
\var_dump((string) $typeResolver->resolve('string', $context));
// Property named: \phpDocumentor\Reflection\Types\Resolver::$keyWords
\var_dump((string) $fqsenResolver->resolve('Types\\Resolver::$keyWords', $context));
// Class named: \My\Example\string
// - Shows the difference between the FqsenResolver and TypeResolver; the FqsenResolver will assume
//   that the given value is not a type but most definitely a reference to another element. This is
//   because conflicts between type keywords and class names can exist and if you know a reference
//   is not a type but an element you can force that keywords are resolved.
\var_dump((string) $fqsenResolver->resolve('string', $context));

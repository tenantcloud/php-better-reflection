<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver;
require '../vendor/autoload.php';
$typeResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
// Will yield an object of type phpDocumentor\Types\Compound
\var_export($typeResolver->resolve('string|integer'));
// Will return the string "string|int"
\var_dump((string) $typeResolver->resolve('string|integer'));

<?php

namespace TenantCloud\BetterReflection\Relocated\ClassConstantOnExprAssertType;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(\stdClass $std, string $string, ?\stdClass $stdOrNull, ?string $stringOrNull) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<stdClass>', $std::class);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*ERROR*', $string::class);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<stdClass>', $stdOrNull::class);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*ERROR*', $stringOrNull::class);
    }
}

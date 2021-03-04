<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3961Php8;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(string $v, string $d, $m) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>&nonEmpty', \explode('.', $v));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', \explode('', $v));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', \explode('.', $v, -2));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>&nonEmpty', \explode('.', $v, 0));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>&nonEmpty', \explode('.', $v, 1));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', \explode($d, $v));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', \explode($m, $v));
    }
}

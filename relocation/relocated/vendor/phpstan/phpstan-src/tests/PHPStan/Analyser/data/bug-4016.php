<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4016;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array<int, int> $a
     */
    public function doFoo(array $a) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, int>', $a);
        $a[] = 2;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, int>&nonEmpty', $a);
        unset($a[0]);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, int>', $a);
    }
    /**
     * @param array<int, int> $a
     */
    public function doBar(array $a) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, int>', $a);
        $a[1] = 2;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, int>&nonEmpty', $a);
        unset($a[1]);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, int>', $a);
    }
}

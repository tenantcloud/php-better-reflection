<?php

namespace TenantCloud\BetterReflection\Relocated\OffsetValueAfterAssign;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array<string> $a
     */
    public function doFoo(array $a, int $i) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $a[$i]);
        $a[$i] = 'foo';
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'foo\'', $a[$i]);
        $i = 1;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $a[$i]);
    }
}

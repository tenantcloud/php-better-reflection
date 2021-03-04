<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4206;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public const ONE = 1;
    public const TWO = 2;
}
function (int $i) : void {
    if ($i === \TenantCloud\BetterReflection\Relocated\Bug4206\Foo::ONE) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $i);
    }
    if ($i === \TenantCloud\BetterReflection\Relocated\Bug4206\Foo::TWO) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('2', $i);
    }
};

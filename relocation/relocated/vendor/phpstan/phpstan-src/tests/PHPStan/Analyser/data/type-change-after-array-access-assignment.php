<?php

namespace TenantCloud\BetterReflection\Relocated\TypeChangeAfterArrayAccessAssignment;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param \ArrayAccess<int, int> $ac
     */
    public function doFoo(\ArrayAccess $ac) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $ac['foo'] = 'bar';
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $ac[] = 'foo';
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $ac[] = 1;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $ac[2] = 'bar';
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $i = 1;
        $ac[] = $i;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $ac[] = 'baz';
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $ac[] = ['foo'];
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
    }
}

<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2539;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array<int> $array
     * @param non-empty-array<int> $nonEmptyArray
     */
    public function doFoo(array $array, array $nonEmptyArray) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|false', \current($array));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \current($nonEmptyArray));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \current([]));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3', \current([1, 2, 3]));
        $a = [];
        if (\rand(0, 1)) {
            $a[] = 1;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|false', \current($a));
    }
}

<?php

namespace TenantCloud\BetterReflection\Relocated\ArraySlice;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param non-empty-array $a
     */
    public function nonEmpty(array $a) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', \array_slice($a, 1));
    }
    /**
     * @param mixed $arr
     */
    public function fromMixed($arr) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', \array_slice($arr, 1, 2));
    }
    /**
     * @param array<int, bool> $arr1
     * @param array<string, int> $arr2
     */
    public function preserveTypes(array $arr1, array $arr2) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, bool>', \array_slice($arr1, 1, 2));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, bool>', \array_slice($arr1, 1, 2, \true));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, int>', \array_slice($arr2, 1, 2));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, int>', \array_slice($arr2, 1, 2, \true));
    }
}

<?php

namespace TenantCloud\BetterReflection\Relocated\ForeachDependentKeyValue;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array{foo: int, bar: string} $a
     */
    public function doFoo(array $a) : void
    {
        foreach ($a as $key => $val) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|string', $val);
            if ($key === 'foo') {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $val);
            } else {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $val);
            }
            if ($key === 'bar') {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $val);
            } else {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $val);
            }
        }
    }
}

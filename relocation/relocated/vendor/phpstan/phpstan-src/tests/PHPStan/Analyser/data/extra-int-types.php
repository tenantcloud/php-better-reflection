<?php

namespace TenantCloud\BetterReflection\Relocated\ExtraIntTypes;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param positive-int $positiveInt
     * @param negative-int $negativeInt
     */
    public function doFoo(int $positiveInt, int $negativeInt, string $str) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', $positiveInt);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>', $negativeInt);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \strpos('u', $str) === -1);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', \strpos('u', $str) !== -1);
    }
}

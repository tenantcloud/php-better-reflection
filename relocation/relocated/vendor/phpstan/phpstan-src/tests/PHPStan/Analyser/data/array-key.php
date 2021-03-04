<?php

namespace TenantCloud\BetterReflection\Relocated\ArrayKey;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array-key $arrayKey
     * @param array<array-key, string> $arrayWithArrayKey
     */
    public function doFoo($arrayKey, array $arrayWithArrayKey) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(int|string)', $arrayKey);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', $arrayWithArrayKey);
    }
}

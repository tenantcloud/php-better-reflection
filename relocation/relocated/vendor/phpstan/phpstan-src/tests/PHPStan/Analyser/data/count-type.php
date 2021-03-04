<?php

namespace TenantCloud\BetterReflection\Relocated\CountType;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param non-empty-array $nonEmpty
     */
    public function doFoo(array $nonEmpty)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', \count($nonEmpty));
    }
}

<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2945;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class A
{
    /**
     * @param \stdClass[] $blocks
     *
     * @return void
     */
    public function doFoo(array $blocks)
    {
        foreach ($blocks as $b) {
            if (!$b instanceof \stdClass) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $b);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed~stdClass', $b);
                throw new \TypeError();
            }
            $pk = new \Exception();
            $pk->x = $b->x;
        }
    }
    /**
     * @param \stdClass[] $blocks
     *
     * @return void
     */
    public function doBar(array $blocks)
    {
        foreach ($blocks as $b) {
            if (!$b instanceof \stdClass) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $b);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed~stdClass', $b);
                throw new \TypeError();
            }
            $pk = new \Exception();
            $x = $b->x;
        }
    }
}

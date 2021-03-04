<?php

namespace TenantCloud\BetterReflection\Relocated\NonEmptyArrayKeyType;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param \stdClass[] $items
     */
    public function doFoo(array $items)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<stdClass>', $items);
        if (\count($items) > 0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<stdClass>&nonEmpty', $items);
            foreach ($items as $i => $val) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(int|string)', $i);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $val);
            }
        }
    }
    /**
     * @param \stdClass[] $items
     */
    public function doBar(array $items)
    {
        foreach ($items as $i => $val) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(int|string)', $i);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $val);
        }
    }
}

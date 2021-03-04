<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2648;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param bool[] $list
     */
    public function doFoo(array $list) : void
    {
        if (\count($list) > 1) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<2, max>', \count($list));
            unset($list['fooo']);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<bool>', $list);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($list));
        }
    }
    /**
     * @param bool[] $list
     */
    public function doBar(array $list) : void
    {
        if (\count($list) > 1) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<2, max>', \count($list));
            foreach ($list as $key => $item) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0|int<2, max>', \count($list));
                if ($item === \false) {
                    unset($list[$key]);
                    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($list));
                }
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($list));
                if (\count($list) === 1) {
                    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', \count($list));
                    break;
                }
            }
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($list));
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($list));
    }
}

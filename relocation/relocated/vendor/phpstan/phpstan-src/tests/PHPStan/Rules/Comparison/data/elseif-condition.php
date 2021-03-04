<?php

namespace TenantCloud\BetterReflection\Relocated\ConstantCondition;

class ElseIfCondition
{
    /**
     * @param int $i
     * @param \stdClass $std
     * @param Foo|Bar $union
     * @param Lorem&Ipsum $intersection
     */
    public function doFoo(int $i, \stdClass $std, $union, $intersection)
    {
        if ($i) {
        } elseif ($std) {
        }
        if ($i) {
        } elseif (!$std) {
        }
        if ($union instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Foo || $union instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Bar) {
        } elseif ($union instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Foo && \true) {
        }
        if ($intersection instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Lorem && $intersection instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Ipsum) {
        } elseif ($intersection instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Lorem && \true) {
        }
    }
}

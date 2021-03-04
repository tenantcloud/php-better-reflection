<?php

namespace TenantCloud\BetterReflection\Relocated;

class FooWithoutNamespace
{
    public function misleadingBoolReturnType() : \TenantCloud\BetterReflection\Relocated\boolean
    {
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return new \TenantCloud\BetterReflection\Relocated\boolean();
        }
    }
    public function misleadingIntReturnType() : \TenantCloud\BetterReflection\Relocated\integer
    {
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return new \TenantCloud\BetterReflection\Relocated\integer();
        }
    }
    public function misleadingMixedReturnType() : mixed
    {
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return new \TenantCloud\BetterReflection\Relocated\mixed();
        }
    }
}

<?php

namespace TenantCloud\BetterReflection\Relocated;

class FooClassForNodeScopeResolverTestingWithoutNamespace
{
    public function misleadingBoolReturnType() : \TenantCloud\BetterReflection\Relocated\boolean
    {
    }
    public function misleadingIntReturnType() : \TenantCloud\BetterReflection\Relocated\integer
    {
    }
}
function () {
    $foo = new \TenantCloud\BetterReflection\Relocated\FooClassForNodeScopeResolverTestingWithoutNamespace();
    die;
};

<?php

namespace TenantCloud\BetterReflection\Relocated\ProtectedMethodCallFromParent;

class ParentClass
{
    public function test()
    {
        $a = new \TenantCloud\BetterReflection\Relocated\ProtectedMethodCallFromParent\ChildClass();
        $a->onChild();
    }
}
class ChildClass extends \TenantCloud\BetterReflection\Relocated\ProtectedMethodCallFromParent\ParentClass
{
    protected function onChild()
    {
    }
}

<?php

namespace TenantCloud\BetterReflection\Relocated\InvokeMagicInvokeMethod;

class ClassForCallable
{
    public function doFoo(callable $foo)
    {
    }
}
class ClassWithInvoke
{
    public function __invoke()
    {
    }
}
function () {
    $foo = new \TenantCloud\BetterReflection\Relocated\InvokeMagicInvokeMethod\ClassForCallable();
    $foo->doFoo(new \TenantCloud\BetterReflection\Relocated\InvokeMagicInvokeMethod\ClassWithInvoke());
    $foo->doFoo($foo);
};

<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited;

class A
{
}
class B extends \TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\A
{
}
class C extends \TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\B
{
}
class D
{
}
class GrandparentClass
{
    /** @param A $one */
    public function method($one, $two) : void
    {
    }
}
class ParentClass extends \TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
    }
}
class ChildClass extends \TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
    }
}
function (\TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\ParentClass $foo) {
    $foo->method(new \TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\A(), new \TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\D(), new \TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\D());
    // expects A, B
};
function (\TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\ChildClass $foo) {
    $foo->method(new \TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\C(), new \TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\B(), new \TenantCloud\BetterReflection\Relocated\CallMethodsPhpDocMergeParamInherited\D());
    // expects C, B
};

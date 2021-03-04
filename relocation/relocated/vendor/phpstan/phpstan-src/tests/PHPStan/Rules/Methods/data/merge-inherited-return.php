<?php

namespace TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited;

class A
{
}
class B extends \TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited\A
{
}
class C extends \TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited\B
{
}
class D extends \TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited\B();
    }
}
interface InterfaceC
{
    /** @return C */
    public function method();
}
interface InterfaceA
{
    /** @return A */
    public function method();
}
class ParentClass extends \TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited\GrandparentClass implements \TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited\InterfaceC, \TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited\InterfaceA
{
    /** Some comment */
    public function method()
    {
        return new \TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass extends \TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    public function method()
    {
        return new \TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass2 extends \TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
        return new \TenantCloud\BetterReflection\Relocated\ReturnTypePhpDocMergeReturnInherited\B();
    }
}

<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class A
{
}
class B extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn\A
{
}
class C extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn\B
{
}
class D extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn\B();
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
class ParentClass extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn\GrandparentClass implements \TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn\InterfaceC, \TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn\InterfaceA
{
    /** Some comment */
    public function method()
    {
    }
}
class ChildClass extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn\ParentClass
{
    public function method()
    {
    }
}
class ChildClass2 extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
    }
}
function (\TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn\ParentClass $foo) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingReturn\\B', $foo->method());
};
function (\TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn\ChildClass $foo) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingReturn\\B', $foo->method());
};
function (\TenantCloud\BetterReflection\Relocated\InheritDocMergingReturn\ChildClass2 $foo) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingReturn\\D', $foo->method());
};

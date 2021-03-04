<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\InheritDocMergingParam;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class A
{
}
class B extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingParam\A
{
}
class C extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingParam\B
{
}
class GrandparentClass
{
    /** @param A $one */
    public function method($one, $two) : void
    {
    }
}
class ParentClass extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingParam\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingParam\\A', $uno);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingParam\\B', $dos);
    }
}
class ChildClass extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingParam\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingParam\\C', $one);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingParam\\B', $two);
    }
}

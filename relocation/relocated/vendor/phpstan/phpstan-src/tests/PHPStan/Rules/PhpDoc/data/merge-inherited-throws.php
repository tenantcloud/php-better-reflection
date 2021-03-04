<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\InvalidThrowsPhpDocMergeInherited;

class A
{
}
class B
{
}
class C
{
}
class D
{
}
class One
{
    /** @throws A */
    public function method() : void
    {
    }
}
interface InterfaceOne
{
    /** @throws B */
    public function method() : void;
}
class Two extends \TenantCloud\BetterReflection\Relocated\InvalidThrowsPhpDocMergeInherited\One implements \TenantCloud\BetterReflection\Relocated\InvalidThrowsPhpDocMergeInherited\InterfaceOne
{
    /**
     * @throws C
     * @throws D
     */
    public function method() : void
    {
    }
}
class Three extends \TenantCloud\BetterReflection\Relocated\InvalidThrowsPhpDocMergeInherited\Two
{
    /** Some comment */
    public function method() : void
    {
    }
}
class Four extends \TenantCloud\BetterReflection\Relocated\InvalidThrowsPhpDocMergeInherited\Three
{
    public function method() : void
    {
    }
}

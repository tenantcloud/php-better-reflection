<?php

namespace TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor;

class A
{
}
class B extends \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\A
{
}
/**
 * @template T
 *
 * @param callable(T):void $t1
 * @param T $t2
 */
function apply(callable $t1, $t2) : void
{
    $t1($t2);
}
/**
 * @template T
 *
 * @param T $t2
 * @param callable(T):void $t1
 */
function applyReversed($t2, callable $t1) : void
{
    $t1($t2);
}
function testApply()
{
    apply(function (\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\A $_i) : void {
    }, new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\A());
    apply(function (\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\B $_i) : void {
    }, new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\B());
    apply(function (\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\A $_i) : void {
    }, new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\B());
    apply(function (\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\B $_i) : void {
    }, new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\A());
    applyReversed(new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\A(), function (\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\A $_i) : void {
    });
    applyReversed(new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\B(), function (\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\B $_i) : void {
    });
    applyReversed(new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\B(), function (\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\A $_i) : void {
    });
    applyReversed(new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\A(), function (\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\VaryingAcceptor\B $_i) : void {
    });
}
/**
 * @template T
 *
 * @param callable(callable():T):T $closure
 * @return T
 */
function bar(callable $closure)
{
    throw new \Exception();
}
/** @param callable(callable():int):string $callable */
function testBar($callable) : void
{
    bar($callable);
}

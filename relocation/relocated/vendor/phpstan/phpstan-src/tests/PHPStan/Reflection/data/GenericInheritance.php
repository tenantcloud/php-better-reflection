<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\GenericInheritance;

/**
 * interface I0
 *
 * @template T
 */
interface I0
{
}
/**
 * interface I1
 *
 * @template T
 */
interface I1
{
}
/**
 * interface I
 *
 * @template T
 *
 * @extends I0<T>
 * @extends I1<int>
 */
interface I extends \TenantCloud\BetterReflection\Relocated\GenericInheritance\I0, \TenantCloud\BetterReflection\Relocated\GenericInheritance\I1
{
}
/**
 * class C0
 *
 * @template T
 *
 * @implements I<T>
 */
class C0 implements \TenantCloud\BetterReflection\Relocated\GenericInheritance\I
{
}
/**
 * class C
 *
 * @extends C0<\DateTime>
 */
class C extends \TenantCloud\BetterReflection\Relocated\GenericInheritance\C0
{
}
/**
 * @implements I<\DateTimeInterface>
 */
class Override extends \TenantCloud\BetterReflection\Relocated\GenericInheritance\C
{
}

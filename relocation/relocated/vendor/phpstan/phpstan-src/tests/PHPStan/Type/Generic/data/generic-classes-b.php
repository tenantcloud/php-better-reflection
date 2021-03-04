<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Test\B;

/** @template T */
interface I
{
}
/**
 * @template T
 * @implements I<T>
 */
class IImpl implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Test\B\I
{
}

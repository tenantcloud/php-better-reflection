<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use ArrayAccess;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return array|ArrayAccess
 */
function isArrayAccessible($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isArrayAccessible($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return null|array|ArrayAccess
 */
function nullOrIsArrayAccessible($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsArrayAccessible($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<array|ArrayAccess>
 */
function allIsArrayAccessible($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsArrayAccessible($value);
    return $value;
}

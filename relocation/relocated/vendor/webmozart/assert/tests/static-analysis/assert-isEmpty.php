<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @return null
 */
function isEmptyNullableObject(?object $value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @return ""|"0"
 */
function isEmptyString(string $value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @return (0)
 */
function isEmptyInt(int $value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @return false
 */
function isEmptyBool(bool $value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @return array<empty, empty>
 */
function isEmptyArray(array $value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @return null|empty
 */
function nullOrIsEmpty(?object $value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<empty>
 */
function allIsEmpty($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsEmpty($value);
    return $value;
}

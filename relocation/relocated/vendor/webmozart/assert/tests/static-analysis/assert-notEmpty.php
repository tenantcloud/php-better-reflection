<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 */
function notEmptyNullableObject(?object $value) : object
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::notEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @return non-empty-string
 */
function notEmptyString(string $value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::notEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @return true
 */
function notEmptyBool(bool $value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::notEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @return non-empty-array
 */
function notEmptyArray(array $value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::notEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function nullOrNotEmpty($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrNotEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function allNotEmpty($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allNotEmpty($value);
    return $value;
}

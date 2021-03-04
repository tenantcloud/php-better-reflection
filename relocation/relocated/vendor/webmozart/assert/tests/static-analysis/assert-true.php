<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return true
 */
function true($value) : bool
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::true($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return null|true
 */
function nullOrTrue($value) : ?bool
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrTrue($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<true>
 */
function allTrue($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allTrue($value);
    return $value;
}

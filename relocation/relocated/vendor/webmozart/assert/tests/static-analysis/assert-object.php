<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function object($value) : object
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::object($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function nullOrObject($value) : ?object
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrObject($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<object>
 */
function allObject($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allObject($value);
    return $value;
}

<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return numeric
 */
function integerish($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::integerish($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return null|numeric
 */
function nullOrIntegerish($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIntegerish($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<numeric>
 */
function allIntegerish($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIntegerish($value);
    return $value;
}

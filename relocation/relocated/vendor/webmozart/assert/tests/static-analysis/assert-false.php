<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return false
 */
function false($value) : bool
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::false($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return null|false
 */
function nullOrFalse($value) : ?bool
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrFalse($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<false>
 */
function allFalse($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allFalse($value);
    return $value;
}

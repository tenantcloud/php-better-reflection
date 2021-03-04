<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function isTraversable($value) : iterable
{
    /** @psalm-suppress DeprecatedMethod */
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isTraversable($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function nullOrIsTraversable($value) : ?iterable
{
    /** @psalm-suppress DeprecatedMethod */
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsTraversable($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<iterable>
 */
function allIsTraversable($value) : iterable
{
    /** @psalm-suppress DeprecatedMethod */
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsTraversable($value);
    return $value;
}

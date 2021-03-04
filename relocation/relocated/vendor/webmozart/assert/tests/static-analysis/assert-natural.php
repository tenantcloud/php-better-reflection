<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function natural($value) : int
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::natural($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function nullOrNatural($value) : ?int
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrNatural($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<int>
 */
function allNatural($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allNatural($value);
    return $value;
}

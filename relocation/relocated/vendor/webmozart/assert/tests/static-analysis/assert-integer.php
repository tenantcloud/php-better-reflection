<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function integer($value) : int
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::integer($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function nullOrInteger($value) : ?int
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrInteger($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<int>
 */
function allInteger($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allInteger($value);
    return $value;
}

<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function boolean($value) : bool
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::boolean($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function nullOrBoolean($value) : ?bool
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrBoolean($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<bool>
 */
function allBoolean($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allBoolean($value);
    return $value;
}

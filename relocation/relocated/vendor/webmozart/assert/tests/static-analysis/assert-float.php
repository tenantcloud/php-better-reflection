<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function float($value) : float
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::float($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function nullOrFloat($value) : ?float
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrFloat($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<float>
 */
function allFloat($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allFloat($value);
    return $value;
}

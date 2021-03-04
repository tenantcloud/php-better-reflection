<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param mixed $min
 * @param mixed $max
 *
 * @return mixed
 */
function range($value, $min, $max)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::range($value, $min, $max);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param mixed $min
 * @param mixed $max
 *
 * @return mixed
 */
function nullOrRange($value, $min, $max)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrRange($value, $min, $max);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param mixed $min
 * @param mixed $max
 *
 * @return mixed
 */
function allRange($value, $min, $max)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allRange($value, $min, $max);
    return $value;
}

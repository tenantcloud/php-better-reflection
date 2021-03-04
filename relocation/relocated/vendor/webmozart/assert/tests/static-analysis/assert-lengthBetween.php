<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param int|float $min
 * @param int|float $max
 */
function lengthBetween(string $value, $min, $max) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::lengthBetween($value, $min, $max);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param int|float $min
 * @param int|float $max
 */
function nullOrLengthBetween(?string $value, $min, $max) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrLengthBetween($value, $min, $max);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 * @param int|float $min
 * @param int|float $max
 *
 * @return iterable<string>
 */
function allLengthBetween(iterable $value, $min, $max) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allLengthBetween($value, $min, $max);
    return $value;
}

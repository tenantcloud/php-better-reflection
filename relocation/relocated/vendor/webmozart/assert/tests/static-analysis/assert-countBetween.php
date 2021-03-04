<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use Countable;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @param Countable|array $value
 * @param int|float $min
 * @param int|float $max
 *
 * @return Countable|array
 */
function countBetween($value, $min, $max)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::countBetween($value, $min, $max);
    return $value;
}
/**
 * @param null|Countable|array $value
 * @param int|float $min
 * @param int|float $max
 *
 * @return null|Countable|array
 */
function nullOrCountBetween($value, $min, $max)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrCountBetween($value, $min, $max);
    return $value;
}
/**
 * @param iterable<Countable|array> $value
 * @param int|float $min
 * @param int|float $max
 *
 * @return iterable<Countable|array>
 */
function allCountBetween(iterable $value, $min, $max) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allCountBetween($value, $min, $max);
    return $value;
}

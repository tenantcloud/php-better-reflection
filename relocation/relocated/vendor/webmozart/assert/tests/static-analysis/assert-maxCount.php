<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use Countable;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @param Countable|array $array
 * @param int|float $max
 *
 * @return Countable|array
 */
function maxCount($array, $max)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::maxCount($array, $max);
    return $array;
}
/**
 * @param null|Countable|array $array
 * @param int|float $max
 *
 * @return null|Countable|array
 */
function nullOrMaxCount($array, $max)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrMaxCount($array, $max);
    return $array;
}
/**
 * @param iterable<Countable|array> $array
 * @param int|float $max
 *
 * @return iterable<Countable|array>
 */
function allMaxCount(iterable $array, $max) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allMaxCount($array, $max);
    return $array;
}

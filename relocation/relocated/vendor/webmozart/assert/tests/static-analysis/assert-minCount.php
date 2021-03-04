<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use Countable;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @param Countable|array $array
 * @param int|float $min
 *
 * @return Countable|array
 */
function minCount($array, $min)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::minCount($array, $min);
    return $array;
}
/**
 * @param null|Countable|array $array
 * @param int|float $min
 *
 * @return null|Countable|array
 */
function nullOrMinCount($array, $min)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrMinCount($array, $min);
    return $array;
}
/**
 * @param iterable<Countable|array> $array
 * @param int|float $min
 *
 * @return iterable<Countable|array>
 */
function allMinCount($array, $min)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allMinCount($array, $min);
    return $array;
}

<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use Countable;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @param Countable|array $value
 *
 * @return Countable|array
 */
function count($value, int $number)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::count($value, $number);
    return $value;
}
/**
 * @param null|Countable|array $value
 *
 * @return null|Countable|array
 */
function nullOrCount($value, int $number)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrCount($value, $number);
    return $value;
}
/**
 * @param iterable<Countable|array> $value
 *
 * @return iterable<Countable|array>
 */
function allCount(iterable $value, int $number) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allCount($value, $number);
    return $value;
}

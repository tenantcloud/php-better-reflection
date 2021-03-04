<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param int|float $max
 */
function maxLength(string $value, $max) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::maxLength($value, $max);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param int|float $max
 */
function nullOrMaxLength(?string $value, $max) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrMaxLength($value, $max);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 * @param int|float $max
 *
 * @return iterable<string>
 */
function allMaxLength(iterable $value, $max) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allMaxLength($value, $max);
    return $value;
}

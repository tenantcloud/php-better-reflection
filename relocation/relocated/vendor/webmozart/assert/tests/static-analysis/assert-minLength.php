<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param int|float $min
 */
function minLength(string $value, $min) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::minLength($value, $min);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param int|float $min
 */
function nullOrMinLength(?string $value, $min) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrMinLength($value, $min);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 * @param int|float $min
 *
 * @return iterable<string>
 */
function allMinLength(iterable $value, $min) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allMinLength($value, $min);
    return $value;
}

<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 */
function length(string $value, int $length) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::length($value, $length);
    return $value;
}
/**
 * @psalm-pure
 */
function nullOrLength(?string $value, int $length) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrLength($value, $length);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 *
 * @return iterable<string>
 */
function allLength(iterable $value, int $length) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allLength($value, $length);
    return $value;
}

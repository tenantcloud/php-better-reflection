<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 */
function contains(string $value, string $subString) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::contains($value, $subString);
    return $value;
}
/**
 * @psalm-pure
 */
function nullOrContains(?string $value, string $subString) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrContains($value, $subString);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 *
 * @return iterable<string>
 */
function allContains(iterable $value, string $subString) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allContains($value, $subString);
    return $value;
}

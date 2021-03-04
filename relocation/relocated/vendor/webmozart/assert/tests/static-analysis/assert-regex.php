<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 */
function regex(string $value, string $pattern) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::regex($value, $pattern);
    return $value;
}
/**
 * @psalm-pure
 */
function nullOrRegex(?string $value, string $pattern) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrRegex($value, $pattern);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 *
 * @return iterable<string>
 */
function allRegex(iterable $value, string $pattern) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allRegex($value, $pattern);
    return $value;
}

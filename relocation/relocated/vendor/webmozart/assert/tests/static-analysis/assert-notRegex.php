<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 */
function notRegex(string $value, string $pattern) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::notRegex($value, $pattern);
    return $value;
}
/**
 * @psalm-pure
 */
function nullOrNotRegex(?string $value, string $pattern) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrNotRegex($value, $pattern);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 *
 * @return iterable<string>
 */
function allNotRegex(iterable $value, string $pattern) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allNotRegex($value, $pattern);
    return $value;
}

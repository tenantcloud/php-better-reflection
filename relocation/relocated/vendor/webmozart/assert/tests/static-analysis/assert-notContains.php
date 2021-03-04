<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 */
function notContains(string $value, string $subString) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::notContains($value, $subString);
    return $value;
}
/**
 * @psalm-pure
 */
function nullOrNotContains(?string $value, string $subString) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrNotContains($value, $subString);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 *
 * @return iterable<string>
 */
function allNotContains(iterable $value, string $subString) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allNotContains($value, $subString);
    return $value;
}

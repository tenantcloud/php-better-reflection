<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @return lowercase-string
 */
function lower(string $value) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::lower($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @return null|lowercase-string
 */
function nullOrLower(?string $value) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrLower($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 *
 * @return iterable<lowercase-string>
 */
function allLower(iterable $value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allLower($value);
    return $value;
}

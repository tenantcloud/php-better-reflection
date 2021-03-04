<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 */
function startsWith(string $value, string $prefix) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::startsWith($value, $prefix);
    return $value;
}
/**
 * @psalm-pure
 */
function nullOrStartsWith(?string $value, string $prefix) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrStartsWith($value, $prefix);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 *
 * @return iterable<string>
 */
function allStartsWith(iterable $value, string $prefix) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allStartsWith($value, $prefix);
    return $value;
}

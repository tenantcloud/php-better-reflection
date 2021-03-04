<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 */
function upper(string $value) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::upper($value);
    return $value;
}
/**
 * @psalm-pure
 */
function nullOrUpper(?string $value) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrUpper($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 *
 * @return iterable<string>
 */
function allUpper(iterable $value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allUpper($value);
    return $value;
}

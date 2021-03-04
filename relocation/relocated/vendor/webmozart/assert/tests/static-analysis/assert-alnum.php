<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 */
function alnum(string $value) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::alnum($value);
    return $value;
}
/**
 * @psalm-pure
 */
function nullOrAlnum(?string $value) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrAlnum($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 *
 * @return iterable<string>
 */
function allAllnum(iterable $value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allAlnum($value);
    return $value;
}

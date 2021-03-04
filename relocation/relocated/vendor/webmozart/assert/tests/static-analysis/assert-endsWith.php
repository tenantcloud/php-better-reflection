<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 */
function endsWith(string $value, string $suffix) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::endsWith($value, $suffix);
    return $value;
}
/**
 * @psalm-pure
 */
function nullOrEndsWith(?string $value, string $suffix) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrEndsWith($value, $suffix);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 *
 * @return iterable<string>
 */
function allEndsWith(iterable $value, string $suffix) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allEndsWith($value, $suffix);
    return $value;
}

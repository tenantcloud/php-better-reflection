<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
function readable(string $value) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::readable($value);
    return $value;
}
function nullOrReadable(?string $value) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrReadable($value);
    return $value;
}
/**
 * @param iterable<string> $value
 *
 * @return iterable<string>
 */
function allReadable(iterable $value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allReadable($value);
    return $value;
}

<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function string($value) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::string($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function nullOrString($value) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrString($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<string>
 */
function allString($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allString($value);
    return $value;
}

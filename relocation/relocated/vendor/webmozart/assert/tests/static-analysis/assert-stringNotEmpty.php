<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return non-empty-string
 */
function stringNotEmpty($value) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::stringNotEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return null|non-empty-string
 */
function nullOrStringNotEmpty($value) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrStringNotEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<non-empty-string>
 */
function allStringNotEmpty($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allStringNotEmpty($value);
    return $value;
}

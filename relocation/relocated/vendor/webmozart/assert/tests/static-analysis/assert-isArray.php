<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function isArray($value) : array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isArray($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function nullOrIsArray($value) : ?array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsArray($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<array>
 */
function allIsArray($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsArray($value);
    return $value;
}

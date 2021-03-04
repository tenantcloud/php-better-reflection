<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use Serializable;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param object|string $value
 *
 * @psalm-return class-string<Serializable>|Serializable
 */
function isAOf($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isAOf($value, \Serializable::class);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param null|object|string $value
 *
 * @psalm-return null|class-string<Serializable>|Serializable
 */
function nullOrIsAOf($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsAOf($value, \Serializable::class);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<object|string> $value
 *
 * @return iterable<class-string<Serializable>|Serializable>
 */
function allIsAOf($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsAOf($value, \Serializable::class);
    return $value;
}

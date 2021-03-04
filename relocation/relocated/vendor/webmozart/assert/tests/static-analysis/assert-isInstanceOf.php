<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use Serializable;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function isInstanceOf($value) : \Serializable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isInstanceOf($value, \Serializable::class);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function nullOrIsInstanceOf($value) : ?\Serializable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsInstanceOf($value, \Serializable::class);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<Serializable>
 */
function allIsInstanceOf($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsInstanceOf($value, \Serializable::class);
    return $value;
}

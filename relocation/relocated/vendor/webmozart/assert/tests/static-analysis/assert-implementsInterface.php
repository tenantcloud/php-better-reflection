<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use Serializable;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return class-string<Serializable>
 */
function implementsInterface($value) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::implementsInterface($value, \Serializable::class);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return null|class-string<Serializable>
 */
function nullOrImplementsInterface($value) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrImplementsInterface($value, \Serializable::class);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<class-string<Serializable>>
 */
function allImplementsInterface($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allImplementsInterface($value, \Serializable::class);
    return $value;
}

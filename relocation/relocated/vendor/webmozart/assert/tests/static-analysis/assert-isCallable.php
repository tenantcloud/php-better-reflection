<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function isCallable($value) : callable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isCallable($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function nullOrIsCallable($value) : ?callable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsCallable($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<callable>
 */
function allIsCallable($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsCallable($value);
    return $value;
}

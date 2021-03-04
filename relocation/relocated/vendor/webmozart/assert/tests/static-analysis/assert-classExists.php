<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @param mixed $value
 *
 * @return class-string
 */
function classExists($value) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::classExists($value);
    return $value;
}
/**
 * @param mixed $value
 *
 * @return class-string|null
 */
function nullOrClassExists($value) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrClassExists($value);
    return $value;
}
/**
 * @param mixed $value
 *
 * @return iterable<class-string>
 */
function allClassExists($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allClassExists($value);
    return $value;
}

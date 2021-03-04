<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @param mixed $value
 *
 * @return class-string
 */
function interfaceExists($value) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::interfaceExists($value);
    return $value;
}
/**
 * @param mixed $value
 *
 * @return null|class-string
 */
function nullOrInterfaceExists($value) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrInterfaceExists($value);
    return $value;
}
/**
 * @param mixed $value
 *
 * @return iterable<class-string>
 */
function allInterfaceExists($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allInterfaceExists($value);
    return $value;
}

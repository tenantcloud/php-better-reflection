<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param object|string $value
 * @param array<class-string> $classes
 *
 * @return object|string
 */
function isAnyOf($value, array $classes)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isAnyOf($value, $classes);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param null|object|string $value
 * @param array<class-string> $classes
 *
 * @return null|object|string
 */
function nullOrIsAnyOf($value, array $classes)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsAnyOf($value, $classes);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<object|string> $value
 * @param array<class-string> $classes
 *
 * @return iterable<object|string>
 */
function allIsAnyOf($value, array $classes) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsAnyOf($value, $classes);
    return $value;
}

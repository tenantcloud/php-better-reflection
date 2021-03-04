<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param array<class-string> $classes
 *
 * @return mixed
 */
function isInstanceOfAny($value, array $classes)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isInstanceOfAny($value, $classes);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param array<class-string> $classes
 *
 * @return mixed
 */
function nullOrIsInstanceOfAny($value, array $classes)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsInstanceOfAny($value, $classes);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param array<class-string> $classes
 *
 * @return mixed
 */
function allIsInstanceOfAny($value, array $classes)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsInstanceOfAny($value, $classes);
    return $value;
}

<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param class-string|object $classOrObject
 * @param mixed $property
 *
 * @return class-string|object
 */
function propertyNotExists($classOrObject, $property)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::propertyNotExists($classOrObject, $property);
    return $classOrObject;
}
/**
 * @psalm-pure
 *
 * @param null|class-string|object $classOrObject
 * @param mixed $property
 *
 * @return null|class-string|object
 */
function nullOrPropertyNotExists($classOrObject, $property)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrPropertyNotExists($classOrObject, $property);
    return $classOrObject;
}
/**
 * @psalm-pure
 *
 * @param iterable<class-string|object> $classOrObject
 * @param mixed $property
 *
 * @return iterable<class-string|object>
 */
function allPropertyNotExists(iterable $classOrObject, $property) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allPropertyNotExists($classOrObject, $property);
    return $classOrObject;
}

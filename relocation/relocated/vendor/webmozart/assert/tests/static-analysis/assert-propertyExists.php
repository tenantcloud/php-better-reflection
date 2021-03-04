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
function propertyExists($classOrObject, $property)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::propertyExists($classOrObject, $property);
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
function nullOrPropertyExists($classOrObject, $property)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrPropertyExists($classOrObject, $property);
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
function allPropertyExists(iterable $classOrObject, $property) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allPropertyExists($classOrObject, $property);
    return $classOrObject;
}

<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param class-string|object $classOrObject
 * @param mixed $method
 *
 * @return class-string|object
 */
function methodExists($classOrObject, $method)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::methodExists($classOrObject, $method);
    return $classOrObject;
}
/**
 * @psalm-pure
 *
 * @param null|class-string|object $classOrObject
 * @param mixed $method
 *
 * @return null|class-string|object
 */
function nullOrMethodExists($classOrObject, $method)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrMethodExists($classOrObject, $method);
    return $classOrObject;
}
/**
 * @psalm-pure
 *
 * @param iterable<class-string|object> $classOrObject
 * @param mixed $method
 *
 * @return iterable<class-string|object>
 */
function allMethodExists(iterable $classOrObject, $method) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allMethodExists($classOrObject, $method);
    return $classOrObject;
}

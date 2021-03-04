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
function methodNotExists($classOrObject, $method)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::methodNotExists($classOrObject, $method);
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
function nullOrMethodNotExists($classOrObject, $method)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrMethodNotExists($classOrObject, $method);
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
function allMethodNotExists(iterable $classOrObject, $method) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allMethodNotExists($classOrObject, $method);
    return $classOrObject;
}

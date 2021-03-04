<?php

namespace TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements;

/**
 * @template T
 * @template U of \Exception
 */
interface FooGeneric
{
}
/**
 * @template T
 * @template V of \Exception
 */
interface FooGeneric2
{
}
/**
 * @template T
 * @template W of \Exception
 */
interface FooGeneric3
{
}
/**
 * @implements FooGeneric<int, \InvalidArgumentException>
 */
class FooDoesNotImplementAnything
{
}
/**
 * @implements FooGeneric<int, \InvalidArgumentException>
 * @implements FooGeneric2<int, \InvalidArgumentException>
 */
class FooInvalidImplementsTags implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @implements FooGeneric2<int, \InvalidArgumentException>
 */
class FooWrongClassImplemented implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric, \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric3
{
}
/**
 * @implements class-string<T>
 */
class FooWrongTypeInImplementsTag implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @implements FooGeneric<int, \InvalidArgumentException>
 */
class FooCorrect implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @implements FooGeneric<int>
 */
class FooNotEnough implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @implements FooGeneric<int, \InvalidArgumentException, string>
 */
class FooExtraTypes implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @implements FooGeneric<int, \Throwable>
 */
class FooNotSubtype implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @implements FooGeneric<int, \stdClass>
 */
class FooAlsoNotSubtype implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @implements FooGeneric<Zazzuuuu, \Exception>
 */
class FooUnknownClass implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @template T
 * @implements FooGeneric<int, T>
 */
class FooGenericGeneric implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @template T of \Throwable
 * @implements FooGeneric<int, T>
 */
class FooGenericGeneric2 implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @template T of \Exception
 * @implements FooGeneric<int, T>
 */
class FooGenericGeneric3 implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @template T of \InvalidArgumentException
 * @implements FooGeneric<int, T>
 */
class FooGenericGeneric4 implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @template T
 * @implements FooGeneric<T, \Exception>
 */
class FooGenericGeneric5 implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @implements FooGeneric<T, \Exception>
 */
class FooGenericGeneric6 implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @implements FooGeneric<int, T>
 */
class FooGenericGeneric7 implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @implements FooGeneric<int, T>
 * @implements FooGeneric2<int, T>
 */
class FooGenericGeneric8 implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric, \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric2
{
}
interface NonGenericInterface
{
}
class FooImplementsNonGenericInterface implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\NonGenericInterface
{
}
class FooImplementsGenericInterface implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric
{
}
/**
 * @template-covariant T
 * @template U
 */
interface FooGeneric9
{
}
/**
 * @template-covariant T
 * @implements FooGeneric9<T, T>
 */
class FooGeneric10 implements \TenantCloud\BetterReflection\Relocated\ClassAncestorsImplements\FooGeneric9
{
}

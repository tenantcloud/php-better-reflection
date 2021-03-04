<?php

namespace TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends;

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
 * @extends FooGeneric<int, \InvalidArgumentException>
 */
interface FooDoesNotImplementAnything
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 * @extends FooGeneric2<int, \InvalidArgumentException>
 */
interface FooInvalidImplementsTags extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric2<int, \InvalidArgumentException>
 */
interface FooWrongClassImplemented extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric, \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric3
{
}
/**
 * @extends class-string<T>
 */
interface FooWrongTypeInImplementsTag extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 */
interface FooCorrect extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int>
 */
interface FooNotEnough extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException, string>
 */
interface FooExtraTypes extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \Throwable>
 */
interface FooNotSubtype extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \stdClass>
 */
interface FooAlsoNotSubtype extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<Zazzuuuu, \Exception>
 */
interface FooUnknowninterface extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Throwable
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric2 extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Exception
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric3 extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \InvalidArgumentException
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric4 extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<T, \Exception>
 */
interface FooGenericGeneric5 extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<T, \Exception>
 */
interface FooGenericGeneric6 extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric7 extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<int, T>
 * @extends FooGeneric2<int, T>
 */
interface FooGenericGeneric8 extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric, \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric2
{
}
interface NonGenericInterface
{
}
interface ExtendsNonGenericInterface extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\NonGenericInterface
{
}
interface ExtendsGenericInterface extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric
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
 * @extends FooGeneric9<T, T>
 */
interface FooGeneric10 extends \TenantCloud\BetterReflection\Relocated\InterfaceAncestorsExtends\FooGeneric9
{
}

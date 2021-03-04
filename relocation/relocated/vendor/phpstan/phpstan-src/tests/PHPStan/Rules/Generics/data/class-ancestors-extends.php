<?php

namespace TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends;

/**
 * @template T
 * @template U of \Exception
 */
class FooGeneric
{
}
/**
 * @template T
 * @template V of \Exception
 */
class FooGeneric2
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 */
class FooDoesNotExtendAnything
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 * @extends FooGeneric2<int, \InvalidArgumentException>
 */
class FooDuplicateExtendsTags extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric2<int, \InvalidArgumentException>
 */
class FooWrongClassExtended extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends class-string<T>
 */
class FooWrongTypeInExtendsTag extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 */
class FooCorrect extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int>
 */
class FooNotEnough extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException, string>
 */
class FooExtraTypes extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \Throwable>
 */
class FooNotSubtype extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \stdClass>
 */
class FooAlsoNotSubtype extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<Zazzuuuu, \Exception>
 */
class FooUnknownClass extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Throwable
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric2 extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Exception
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric3 extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \InvalidArgumentException
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric4 extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<T, \Exception>
 */
class FooGenericGeneric5 extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<T, \Exception>
 */
class FooGenericGeneric6 extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric7 extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
class FooExtendsNonGenericClass extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooDoesNotExtendAnything
{
}
class FooExtendsGenericClass extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template-covariant T
 * @template U
 */
class FooGeneric8
{
}
/**
 * @template-covariant T
 * @extends FooGeneric8<T, T>
 */
class FooGeneric9 extends \TenantCloud\BetterReflection\Relocated\ClassAncestorsExtends\FooGeneric8
{
}

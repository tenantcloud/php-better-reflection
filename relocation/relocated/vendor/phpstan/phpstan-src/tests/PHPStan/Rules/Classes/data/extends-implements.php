<?php

namespace TenantCloud\BetterReflection\Relocated\ExtendsImplements;

class Foo
{
}
class Bar extends \TenantCloud\BetterReflection\Relocated\ExtendsImplements\Foo implements \TenantCloud\BetterReflection\Relocated\ExtendsImplements\FooInterface
{
}
class Baz extends \TenantCloud\BetterReflection\Relocated\ExtendsImplements\FOO implements \TenantCloud\BetterReflection\Relocated\ExtendsImplements\FOOInterface
{
}
interface FooInterface
{
}
interface BarInterface extends \TenantCloud\BetterReflection\Relocated\ExtendsImplements\FooInterface
{
}
interface BazInterface extends \TenantCloud\BetterReflection\Relocated\ExtendsImplements\FOOInterface
{
}
/**
 * @final
 */
class FinalWithAnnotation
{
}
class ExtendsFinalWithAnnotation extends \TenantCloud\BetterReflection\Relocated\ExtendsImplements\FinalWithAnnotation
{
}

<?php

namespace TenantCloud\BetterReflection\Relocated\UnionIntersection;

class WithFoo
{
    const FOO_CONSTANT = 1;
    /** @var Foo */
    public $foo;
    public function doFoo() : \TenantCloud\BetterReflection\Relocated\UnionIntersection\Foo
    {
    }
    public static function doStaticFoo() : \TenantCloud\BetterReflection\Relocated\UnionIntersection\Foo
    {
    }
}
class WithFooAndBar
{
    const FOO_CONSTANT = 1;
    const BAR_CONSTANT = 1;
    /** @var AnotherFoo */
    public $foo;
    /** @var Bar */
    public $bar;
    public function doFoo() : \TenantCloud\BetterReflection\Relocated\UnionIntersection\AnotherFoo
    {
    }
    public static function doStaticFoo() : \TenantCloud\BetterReflection\Relocated\UnionIntersection\AnotherFoo
    {
    }
    public function doBar() : \TenantCloud\BetterReflection\Relocated\UnionIntersection\Bar
    {
    }
    public static function doStaticBar() : \TenantCloud\BetterReflection\Relocated\UnionIntersection\Bar
    {
    }
}
interface WithFooAndBarInterface
{
    const FOO_CONSTANT = 1;
    const BAR_CONSTANT = 1;
    public function doFoo() : \TenantCloud\BetterReflection\Relocated\UnionIntersection\AnotherFoo;
    public static function doStaticFoo() : \TenantCloud\BetterReflection\Relocated\UnionIntersection\AnotherFoo;
    public function doBar() : \TenantCloud\BetterReflection\Relocated\UnionIntersection\Bar;
    public static function doStaticBar() : \TenantCloud\BetterReflection\Relocated\UnionIntersection\Bar;
}
interface SomeInterface
{
}
class Dolor
{
    const PARENT_CONSTANT = [1, 2, 3];
}
class Ipsum extends \TenantCloud\BetterReflection\Relocated\UnionIntersection\Dolor
{
    const IPSUM_CONSTANT = 'foo';
    /** @var WithFoo|WithFooAndBar */
    private $union;
    /** @var WithFoo|object */
    private $objectUnion;
    public function doFoo(\TenantCloud\BetterReflection\Relocated\UnionIntersection\WithFoo $foo, \TenantCloud\BetterReflection\Relocated\UnionIntersection\WithFoo $foobar, object $object)
    {
        if ($foo instanceof \TenantCloud\BetterReflection\Relocated\UnionIntersection\SomeInterface) {
            if ($foobar instanceof \TenantCloud\BetterReflection\Relocated\UnionIntersection\WithFooAndBarInterface) {
                if ($object instanceof \TenantCloud\BetterReflection\Relocated\UnionIntersection\SomeInterface) {
                    die;
                }
            }
        }
    }
}

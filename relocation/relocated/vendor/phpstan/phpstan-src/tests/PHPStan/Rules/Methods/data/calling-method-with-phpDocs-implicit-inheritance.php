<?php

namespace TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\FooInterface
{
    /**
     * @param int $i
     */
    public function doFoo($i)
    {
    }
    public function doBar($str)
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\Foo
{
    public function doFoo($i)
    {
    }
}
class Baz extends \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\Bar
{
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\Baz();
    $baz->doFoo(1);
    $baz->doFoo('1');
    $baz->doBar('1');
    $baz->doBar(1);
};
class Lorem
{
    /**
     * @param B $b
     * @param C $c
     * @param A $a
     * @param D $d
     */
    public function doLorem($a, $b, $c, $d)
    {
    }
}
class Ipsum extends \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\Lorem
{
    public function doLorem($x, $y, $z, $d)
    {
    }
}
function (\TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\Ipsum $ipsum, \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\A $a, \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\B $b, \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\C $c, \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\D $d) : void {
    $ipsum->doLorem($a, $b, $c, $d);
    $ipsum->doLorem(1, 1, 1, 1);
};
class Dolor extends \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\Ipsum
{
    public function doLorem($g, $h, $i, $d)
    {
    }
}
function (\TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\Dolor $ipsum, \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\A $a, \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\B $b, \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\C $c, \TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\D $d) : void {
    $ipsum->doLorem($a, $b, $c, $d);
    $ipsum->doLorem(1, 1, 1, 1);
};
class TestArrayObject
{
    /**
     * @param \ArrayObject<int, \stdClass> $arrayObject
     */
    public function doFoo(\ArrayObject $arrayObject) : void
    {
        $arrayObject->append(new \Exception());
    }
}
/**
 * @extends \ArrayObject<int, \stdClass>
 */
class TestArrayObject2 extends \ArrayObject
{
}
function (\TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\TestArrayObject2 $arrayObject2) : void {
    $arrayObject2->append(new \Exception());
};
/**
 * @extends \ArrayObject<int, \stdClass>
 */
class TestArrayObject3 extends \ArrayObject
{
    public function append($someValue)
    {
        return parent::append($someValue);
    }
}
function (\TenantCloud\BetterReflection\Relocated\MethodWithPhpDocsImplicitInheritance\TestArrayObject3 $arrayObject3) : void {
    $arrayObject3->append(new \Exception());
};

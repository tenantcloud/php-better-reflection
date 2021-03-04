<?php

namespace TenantCloud\BetterReflection\Relocated\ParentClass;

class Foo
{
    public function doFoo()
    {
        'inParentClass';
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\ParentClass\Foo
{
    use FooTrait;
    public function doBar()
    {
        'inChildClass';
    }
}
function (string $s) {
    die;
};
trait FooTrait
{
    public function doBaz()
    {
        'inTrait';
    }
}

<?php

namespace TenantCloud\BetterReflection\Relocated\AnonymousClassWithInheritedConstructor;

class Foo
{
    public function __construct(int $i, int $j)
    {
        echo $i;
        echo $j;
    }
}
function () {
    new class(1, 2) extends \TenantCloud\BetterReflection\Relocated\AnonymousClassWithInheritedConstructor\Foo
    {
    };
};
class Bar
{
    public final function __construct(int $i, int $j)
    {
        echo $i;
        echo $j;
    }
}
function () {
    new class(1, 2) extends \TenantCloud\BetterReflection\Relocated\AnonymousClassWithInheritedConstructor\Bar
    {
    };
};

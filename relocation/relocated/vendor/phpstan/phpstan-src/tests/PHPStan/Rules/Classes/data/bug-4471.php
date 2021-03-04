<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4471;

abstract class Foo
{
}
interface Bar
{
}
function (\TenantCloud\BetterReflection\Relocated\Bug4471\Foo $foo, \TenantCloud\BetterReflection\Relocated\Bug4471\Bar $bar, \TenantCloud\BetterReflection\Relocated\Bug4471\Baz $baz) : void {
    new $foo();
    new $bar();
    new $foo(1);
    new $baz();
};
function () : void {
    $foo = \TenantCloud\BetterReflection\Relocated\Bug4471\Foo::class;
    new $foo();
    $bar = \TenantCloud\BetterReflection\Relocated\Bug4471\Bar::class;
    new $bar();
};

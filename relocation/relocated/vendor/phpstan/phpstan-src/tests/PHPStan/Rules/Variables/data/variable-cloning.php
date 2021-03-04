<?php

namespace TenantCloud\BetterReflection\Relocated\VariableCloning;

class Foo
{
}
$f = function () {
    $foo = new \TenantCloud\BetterReflection\Relocated\VariableCloning\Foo();
    clone $foo;
    clone new \TenantCloud\BetterReflection\Relocated\VariableCloning\Foo();
    clone \random_int(0, 1) ? 'loremipsum' : 123;
    $stringData = 'abc';
    clone $stringData;
    clone 'abc';
    /** @var Foo|string $bar */
    $bar = doBar();
    clone $bar;
    /** @var Foo|Bar|null $baz */
    $baz = doBaz();
    clone $baz;
    /** @var mixed|string $lorem */
    $lorem = doLorem();
    clone $lorem;
    /** @var object $object */
    $object = doFoo();
    clone $object;
};

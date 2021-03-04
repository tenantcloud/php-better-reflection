<?php

namespace TenantCloud\BetterReflection\Relocated\ClosureReturnTypes;

use TenantCloud\BetterReflection\Relocated\SomeOtherNamespace\Baz;
function () {
    return 1;
};
function () {
    return 'foo';
};
function () {
    return;
};
function () : int {
    return 1;
};
function () : int {
    return 'foo';
};
function () : string {
    return 'foo';
};
function () : string {
    return 1;
};
function () : Foo {
    return new \TenantCloud\BetterReflection\Relocated\ClosureReturnTypes\Foo();
};
function () : Foo {
    return new \TenantCloud\BetterReflection\Relocated\ClosureReturnTypes\Bar();
};
function () : \SomeOtherNamespace\Foo {
    return new \TenantCloud\BetterReflection\Relocated\ClosureReturnTypes\Foo();
};
function () : \SomeOtherNamespace\Foo {
    return new \TenantCloud\BetterReflection\Relocated\SomeOtherNamespace\Foo();
};
function () : Baz {
    return new \TenantCloud\BetterReflection\Relocated\ClosureReturnTypes\Foo();
};
function () : Baz {
    return new \TenantCloud\BetterReflection\Relocated\SomeOtherNamespace\Baz();
};
function () : \Traversable {
    /** @var int[]|\Traversable $foo */
    $foo = doFoo();
    return $foo;
};
function () : \Generator {
    (yield 1);
    return;
};
function () {
    if (\rand(0, 1)) {
        return;
    }
};
function () {
    if (\rand(0, 1)) {
        return null;
    }
};
function () {
    if (\rand(0, 1)) {
        return [];
    }
    return;
    // OK
};
function () : ?array {
    if (\rand(0, 1)) {
        return [];
    }
    return;
    // report
};
function () : string {
    if (\rand(0, 1)) {
        return 'foo';
    }
    function () : int {
        return 1;
    };
    return 'bar';
};
function () : string {
    if (\rand(0, 1)) {
        return 1;
    }
    $c = new class
    {
        public function doFoo() : int
        {
            return 2;
        }
    };
    if (\rand(0, 1)) {
        return 3;
    }
    return 4;
};

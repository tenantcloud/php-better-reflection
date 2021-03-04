<?php

namespace TenantCloud\BetterReflection\Relocated;

function (object $foo) {
    if (\is_a($foo, \TenantCloud\BetterReflection\Relocated\Foo::class)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Foo', $foo);
    }
};
function (object $foo) {
    /** @var class-string<Foo> $fooClassString */
    $fooClassString = 'Foo';
    if (\is_a($foo, $fooClassString)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Foo', $foo);
    }
};
function (string $foo) {
    if (\is_a($foo, \TenantCloud\BetterReflection\Relocated\Foo::class, \true)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<Foo>', $foo);
    }
};
function (string $foo, string $someString) {
    if (\is_a($foo, $someString, \true)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<object>', $foo);
    }
};

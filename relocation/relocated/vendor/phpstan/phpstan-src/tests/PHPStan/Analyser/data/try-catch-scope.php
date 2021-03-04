<?php

namespace TenantCloud\BetterReflection\Relocated\TryCatchScope;

function () {
    $resource = null;
    try {
        $resource = new \TenantCloud\BetterReflection\Relocated\TryCatchScope\Foo();
    } catch (\TenantCloud\BetterReflection\Relocated\TryCatchScope\FooException $e) {
        $resource = new \TenantCloud\BetterReflection\Relocated\TryCatchScope\Foo();
    } catch (\TenantCloud\BetterReflection\Relocated\TryCatchScope\BarException $e) {
        $resource = new \TenantCloud\BetterReflection\Relocated\TryCatchScope\Foo();
    }
    'first';
};
function () {
    $resource = null;
    try {
        $resource = new \TenantCloud\BetterReflection\Relocated\TryCatchScope\Foo();
    } catch (\TenantCloud\BetterReflection\Relocated\TryCatchScope\FooException $e) {
    } catch (\TenantCloud\BetterReflection\Relocated\TryCatchScope\BarException $e) {
        $resource = new \TenantCloud\BetterReflection\Relocated\TryCatchScope\Foo();
    }
    'second';
};
function () {
    $resource = null;
    try {
        $resource = new \TenantCloud\BetterReflection\Relocated\TryCatchScope\Foo();
    } catch (\TenantCloud\BetterReflection\Relocated\TryCatchScope\FooException $e) {
    } catch (\TenantCloud\BetterReflection\Relocated\TryCatchScope\BarException $e) {
    }
    'third';
};

<?php

namespace TenantCloud\BetterReflection\Relocated;

function () {
    if (\class_exists(\TenantCloud\BetterReflection\Relocated\UnknownClass\Foo::class)) {
        echo \TenantCloud\BetterReflection\Relocated\UnknownClass\Foo::class;
    }
};
function () {
    if (\interface_exists(\TenantCloud\BetterReflection\Relocated\UnknownClass\Foo::class)) {
        echo \TenantCloud\BetterReflection\Relocated\UnknownClass\Foo::class;
    }
};
function () {
    if (\trait_exists(\TenantCloud\BetterReflection\Relocated\UnknownClass\Foo::class)) {
        echo \TenantCloud\BetterReflection\Relocated\UnknownClass\Foo::class;
    }
};
function () {
    if (\class_exists(\TenantCloud\BetterReflection\Relocated\UnknownClass\Foo::class)) {
        echo \TenantCloud\BetterReflection\Relocated\UnknownClass\Foo::class;
        echo \TenantCloud\BetterReflection\Relocated\UnknownClass\Bar::class;
        // error
    } else {
        echo \TenantCloud\BetterReflection\Relocated\UnknownClass\Foo::class;
        // error
    }
    echo \TenantCloud\BetterReflection\Relocated\UnknownClass\Foo::class;
    // error
};
function () {
    if (\class_exists('TenantCloud\\BetterReflection\\Relocated\\UnknownClass\\Foo')) {
        echo \TenantCloud\BetterReflection\Relocated\UnknownClass\Foo::class;
    }
};

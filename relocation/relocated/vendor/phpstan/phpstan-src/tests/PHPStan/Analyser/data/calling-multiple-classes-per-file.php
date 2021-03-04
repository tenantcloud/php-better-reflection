<?php

namespace TenantCloud\BetterReflection\Relocated\CallingMultipleClasses;

function () {
    $foo = new \TenantCloud\BetterReflection\Relocated\MultipleClasses\Foo();
    $bar = new \TenantCloud\BetterReflection\Relocated\MultipleClasses\Bar();
    die;
};

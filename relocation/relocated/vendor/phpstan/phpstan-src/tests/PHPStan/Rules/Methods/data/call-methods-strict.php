<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Test;

function () {
    $foo = new \TenantCloud\BetterReflection\Relocated\Test\ClassWithToString();
    $foo->acceptsString($foo);
};

<?php

namespace TenantCloud\BetterReflection\Relocated\MisleadingTypes;

class Foo
{
    public function misleadingBoolReturnType() : \TenantCloud\BetterReflection\Relocated\MisleadingTypes\boolean
    {
    }
    public function misleadingIntReturnType() : \TenantCloud\BetterReflection\Relocated\MisleadingTypes\integer
    {
    }
    public function misleadingMixedReturnType() : mixed
    {
    }
}
function () {
    $foo = new \TenantCloud\BetterReflection\Relocated\MisleadingTypes\Foo();
    die;
};

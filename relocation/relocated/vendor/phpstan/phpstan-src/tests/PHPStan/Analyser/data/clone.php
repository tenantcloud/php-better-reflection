<?php

namespace TenantCloud\BetterReflection\Relocated\CloneOperators;

class Foo
{
}
function () {
    $fooObject = new \TenantCloud\BetterReflection\Relocated\CloneOperators\Foo();
    die;
};

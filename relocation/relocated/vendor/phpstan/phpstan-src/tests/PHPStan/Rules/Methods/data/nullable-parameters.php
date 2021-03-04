<?php

namespace TenantCloud\BetterReflection\Relocated\NullableParameters;

$foo = new \TenantCloud\BetterReflection\Relocated\NullableParameters\Foo();
$foo->doFoo();
$foo->doFoo(1);
$foo->doFoo(1, 2);
$foo->doFoo(1, null);
$foo->doFoo(1, null, 3);

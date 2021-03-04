<?php

namespace TenantCloud\BetterReflection\Relocated\SwitchInstanceOf;

$foo = doFoo();
$bar = doBar();
$baz = doBaz();
switch (\true) {
    case $foo instanceof \TenantCloud\BetterReflection\Relocated\SwitchInstanceOf\Foo:
        break;
    case $bar instanceof \TenantCloud\BetterReflection\Relocated\SwitchInstanceOf\Bar:
        break;
    case $baz instanceof \TenantCloud\BetterReflection\Relocated\SwitchInstanceOf\Baz:
        die;
        break;
}

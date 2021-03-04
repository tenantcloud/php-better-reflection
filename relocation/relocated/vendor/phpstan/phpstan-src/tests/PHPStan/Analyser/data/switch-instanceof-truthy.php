<?php

namespace TenantCloud\BetterReflection\Relocated\SwitchInstanceOf;

/** @var object $object */
$object = doFoo();
$foo = doFoo();
$bar = doBar();
$baz = doBaz();
switch ($object) {
    case $foo instanceof \TenantCloud\BetterReflection\Relocated\SwitchInstanceOf\Foo:
        break;
    case $bar instanceof \TenantCloud\BetterReflection\Relocated\SwitchInstanceOf\Bar:
        break;
    case $baz instanceof \TenantCloud\BetterReflection\Relocated\SwitchInstanceOf\Baz:
        die;
        break;
}

<?php

namespace TenantCloud\BetterReflection\Relocated\SwitchInstanceOfNot;

$foo = doFoo();
switch (\false) {
    case $foo instanceof \TenantCloud\BetterReflection\Relocated\SwitchInstanceOfNot\Foo:
        die;
}

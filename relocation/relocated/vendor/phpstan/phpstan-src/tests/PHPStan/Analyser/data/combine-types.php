<?php

namespace TenantCloud\BetterReflection\Relocated;

$x = null;
/** @var string[] $arr */
$arr = \TenantCloud\BetterReflection\Relocated\doFoo();
foreach ($arr as $foo) {
    $x = $foo;
}
$y = null;
if (\TenantCloud\BetterReflection\Relocated\doFoo()) {
} else {
    if (\TenantCloud\BetterReflection\Relocated\doBar()) {
    } else {
        $y = 1;
    }
}
die;

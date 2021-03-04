<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\AnotherNamespace\Foo;
/** @var Foo[][] $fooses */
$fooses = \TenantCloud\BetterReflection\Relocated\foos();
foreach ($fooses as $foos) {
    foreach ($foos as $foo) {
        die;
    }
}

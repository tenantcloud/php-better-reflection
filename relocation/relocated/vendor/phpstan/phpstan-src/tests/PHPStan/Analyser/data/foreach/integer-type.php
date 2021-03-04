<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\AnotherNamespace\Foo;
/** @var int[] $integers */
$integers = \TenantCloud\BetterReflection\Relocated\foos();
foreach ($integers as $integer) {
    die;
}

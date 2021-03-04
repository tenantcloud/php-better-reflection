<?php

namespace TenantCloud\BetterReflection\Relocated;

$alwaysDefinedNotNullable = 'string';
if (\TenantCloud\BetterReflection\Relocated\doFoo()) {
    $sometimesDefinedVariable = 1;
}
if (isset($alwaysDefinedNotNullable, $sometimesDefinedVariable, $neverDefinedVariable)) {
}

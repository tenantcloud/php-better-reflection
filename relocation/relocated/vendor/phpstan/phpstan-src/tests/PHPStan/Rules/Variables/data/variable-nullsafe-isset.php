<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\VariableNullsafeIsset;

function () : void {
    if (\rand(0, 2)) {
        $foo = 'blabla';
    }
    if (isset($foo->bla)) {
    }
};
function () : void {
    if (\rand(0, 2)) {
        $foo = 'blabla';
    }
    if (isset($foo?->bla)) {
    }
};

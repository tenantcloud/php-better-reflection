<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\IssetNullsafe;

function () {
    if (\rand(0, 2)) {
        $foo = 'blabla';
    }
    if (isset($foo?->bla)) {
    }
};

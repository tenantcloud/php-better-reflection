<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\ReadingWriteOnlyProperties;

function (?\TenantCloud\BetterReflection\Relocated\ReadingWriteOnlyProperties\Foo $foo) : void {
    echo $foo?->readOnlyProperty;
    echo $foo?->usualProperty;
    echo $foo?->writeOnlyProperty;
};

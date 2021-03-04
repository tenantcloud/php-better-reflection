<?php

namespace TenantCloud\BetterReflection\Relocated\LoopVariables;

function () {
    $foo = null;
    $i = 0;
    $nullableVal = null;
    $falseOrObject = \false;
    $anotherFalseOrObject = \false;
    do {
        'begin';
        $foo = new \TenantCloud\BetterReflection\Relocated\LoopVariables\Foo();
        'afterAssign';
        if ($nullableVal === null) {
            'nullableValIf';
            $nullableVal = 1;
        } else {
            $nullableVal *= 10;
            'nullableValElse';
        }
        if ($anotherFalseOrObject === \false) {
            $anotherFalseOrObject = new \TenantCloud\BetterReflection\Relocated\LoopVariables\Foo();
        }
        if (doFoo()) {
            break;
        }
        if ($falseOrObject === \false) {
            $falseOrObject = new \TenantCloud\BetterReflection\Relocated\LoopVariables\Foo();
        }
        if (something()) {
            $foo = new \TenantCloud\BetterReflection\Relocated\LoopVariables\Bar();
            break;
        }
        if (something()) {
            $foo = new \TenantCloud\BetterReflection\Relocated\LoopVariables\Baz();
            return;
        }
        if (something()) {
            $foo = new \TenantCloud\BetterReflection\Relocated\LoopVariables\Lorem();
            continue;
        }
        $i++;
        'end';
    } while (doFoo() && $i++ < 10);
    'afterLoop';
};

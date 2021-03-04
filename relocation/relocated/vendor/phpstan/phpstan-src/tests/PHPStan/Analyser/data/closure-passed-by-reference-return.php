<?php

namespace TenantCloud\BetterReflection\Relocated\ClosurePassedByReference;

function () {
    $fooOrNull = null;
    'beforeCallback';
    $callback = function () use(&$fooOrNull) : void {
        'inCallbackBeforeAssign';
        if ($fooOrNull === null) {
            $fooOrNull = new \TenantCloud\BetterReflection\Relocated\ClosurePassedByReference\Foo();
        }
        'inCallbackAfterAssign';
        return $fooOrNull;
    };
    'afterCallback';
};

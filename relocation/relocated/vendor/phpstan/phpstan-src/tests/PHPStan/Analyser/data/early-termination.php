<?php

namespace TenantCloud\BetterReflection\Relocated\EarlyTermination;

function () {
    $something = \rand(0, 10);
    if ($something % 2 === 0) {
        $var = \true;
    } else {
        $foo = new \TenantCloud\BetterReflection\Relocated\EarlyTermination\Bar();
        if ($something <= 5) {
            \TenantCloud\BetterReflection\Relocated\EarlyTermination\Bar::doBar();
        } elseif ($something <= 7) {
            $foo->doFoo();
        } else {
            baz();
        }
    }
    die;
};

<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2600;

function (\TenantCloud\BetterReflection\Relocated\Bug2600\Foo $foo) : void {
    $foo->doFoo();
    $foo->doFoo(1, 2, 3);
    $foo->doBar();
    $foo->doBar(1, 2, 3);
    $foo->doBaz();
    $foo->doBaz(1, 2, 3);
    $foo->doLorem();
    $foo->doLorem(1, 2, 3);
    $foo->doIpsum();
    $foo->doIpsum(1, 2, 3);
};

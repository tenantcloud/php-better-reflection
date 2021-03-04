<?php

namespace TenantCloud\BetterReflection\Relocated\DeadCodeNoop;

function (\TenantCloud\BetterReflection\Relocated\DeadCodeNoop\stdClass $foo) {
    $foo->foo();
    $arr = [];
    $arr;
    $arr['test'];
    $foo::$test;
    $foo->test;
    'foo';
    1;
    @'foo';
    +1;
    -1;
    +$foo->foo();
    -$foo->foo();
    @$foo->foo();
    isset($test);
    empty($test);
    \true;
    \TenantCloud\BetterReflection\Relocated\DeadCodeNoop\Foo::TEST;
    (string) 1;
};

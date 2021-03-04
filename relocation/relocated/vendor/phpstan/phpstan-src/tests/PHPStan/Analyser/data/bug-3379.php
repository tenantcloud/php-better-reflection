<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3379;

class Foo
{
    const URL = SOME_UNKNOWN_CONST . '/test';
}
function () {
    echo \TenantCloud\BetterReflection\Relocated\Bug3379\Foo::URL;
};

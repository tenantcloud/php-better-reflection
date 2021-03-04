<?php

namespace TenantCloud\BetterReflection\Relocated\VoidParameterTypehint;

function (void $param) : int {
    return 1;
};
function doFoo(void $param) : int
{
    return 1;
}

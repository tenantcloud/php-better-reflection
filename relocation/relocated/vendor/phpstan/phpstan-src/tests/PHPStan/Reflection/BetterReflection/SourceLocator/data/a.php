<?php

namespace TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator;

class AFoo
{
}
function doFoo()
{
}
\define('TenantCloud\\BetterReflection\\Relocated\\TestSingleFileSourceLocator\\SOME_CONSTANT', 1);
const ANOTHER_CONSTANT = 2;
if (\false) {
    class InCondition
    {
    }
} elseif (\true) {
    class InCondition extends \TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator\AFoo
    {
    }
} else {
    class InCondition extends \stdClass
    {
    }
}

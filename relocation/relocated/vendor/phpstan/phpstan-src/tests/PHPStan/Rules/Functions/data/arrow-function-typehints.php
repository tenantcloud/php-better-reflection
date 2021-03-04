<?php

namespace TenantCloud\BetterReflection\Relocated\ArrowFunctionExistingClassesInTypehints;

class Foo
{
    public function doFoo()
    {
        fn(\TenantCloud\BetterReflection\Relocated\ArrowFunctionExistingClassesInTypehints\Bar $bar): \TenantCloud\BetterReflection\Relocated\ArrowFunctionExistingClassesInTypehints\Baz => new \TenantCloud\BetterReflection\Relocated\ArrowFunctionExistingClassesInTypehints\Baz();
    }
}

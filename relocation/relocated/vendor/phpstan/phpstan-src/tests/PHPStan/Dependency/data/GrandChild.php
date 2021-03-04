<?php

namespace TenantCloud\BetterReflection\Relocated\Tests\Dependency;

class GrandChild extends \TenantCloud\BetterReflection\Relocated\Tests\Dependency\Child
{
    /**
     * @param ParamPhpDocReturnTypehint $param
     * @return MethodPhpDocReturnTypehint
     */
    public function doFoo(\TenantCloud\BetterReflection\Relocated\Tests\Dependency\ParamNativeReturnTypehint $param) : \TenantCloud\BetterReflection\Relocated\Tests\Dependency\MethodNativeReturnTypehint
    {
        [, $a, $b] = [1, 2, 3];
    }
}

<?php

namespace TenantCloud\BetterReflection\Relocated\TestAccessPropertiesAssign;

class AccessPropertyWithDimFetch
{
    public function doFoo()
    {
        $this->foo['foo'] = 'test';
        // already reported by a separate rule
    }
    public function doBar()
    {
        $this->foo = 'test';
    }
}

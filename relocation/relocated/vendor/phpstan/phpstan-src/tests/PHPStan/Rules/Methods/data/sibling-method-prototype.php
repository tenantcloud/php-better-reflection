<?php

namespace TenantCloud\BetterReflection\Relocated\SiblingMethodPrototype;

class Base
{
    protected function foo()
    {
    }
}
class Other extends \TenantCloud\BetterReflection\Relocated\SiblingMethodPrototype\Base
{
    protected function foo()
    {
    }
}
class Child extends \TenantCloud\BetterReflection\Relocated\SiblingMethodPrototype\Base
{
    public function bar()
    {
        $other = new \TenantCloud\BetterReflection\Relocated\SiblingMethodPrototype\Other();
        $other->foo();
    }
}
function () {
    new class extends \TenantCloud\BetterReflection\Relocated\SiblingMethodPrototype\Base
    {
        public function bar()
        {
            $other = new \TenantCloud\BetterReflection\Relocated\SiblingMethodPrototype\Other();
            $other->foo();
        }
    };
};

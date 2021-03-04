<?php

namespace TenantCloud\BetterReflection\Relocated\AnonymousClassWrongFilename;

class Foo
{
    public function doFoo() : void
    {
        $foo = new class
        {
            /**
             * @param self $test
             * @return Bar
             */
            public function doBar($test) : \TenantCloud\BetterReflection\Relocated\AnonymousClassWrongFilename\Bar
            {
                return new \TenantCloud\BetterReflection\Relocated\AnonymousClassWrongFilename\Bar();
            }
        };
        $bar = $foo->doBar($this);
        $bar->test();
    }
}

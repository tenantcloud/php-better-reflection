<?php

namespace TenantCloud\BetterReflection\Relocated\CaseInsensitivePhpDocs;

use TenantCloud\BetterReflection\Relocated\Foo\Bar;
use TenantCloud\BetterReflection\Relocated\Foo\Baz as Lorem;
class Test
{
    /** @var bar */
    private $bar;
    /** @var lOREM */
    private $lorem;
    public function doFoo()
    {
        die;
    }
}

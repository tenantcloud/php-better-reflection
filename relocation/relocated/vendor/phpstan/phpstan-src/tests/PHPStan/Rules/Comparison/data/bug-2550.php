<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2550;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo()
    {
        $apples = [1, 'a'];
        foreach ($apples as $apple) {
            if (\is_numeric($apple)) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $apple);
            }
        }
    }
}

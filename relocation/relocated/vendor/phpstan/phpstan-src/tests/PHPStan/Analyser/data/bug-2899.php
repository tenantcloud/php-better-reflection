<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2899;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(string $s, $mixed)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \date('Y'));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', \date('Y.m.d'));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', \date($s));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', \date($mixed));
    }
}

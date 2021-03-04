<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2375;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo($mixed, int $int, string $s, float $f) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'a\', \'b\', \'c\', \'d\')', \range('a', 'd'));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'a\', \'c\', \'e\', \'g\', \'i\')', \range('a', 'i', 2));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', \range($s, $s));
    }
}

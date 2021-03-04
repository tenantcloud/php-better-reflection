<?php

namespace TenantCloud\BetterReflection\Relocated\Bug1924;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Bug1924
{
    function getArrayOrNull() : ?array
    {
        return \rand(0, 1) ? [1, 2, 3] : null;
    }
    function foo() : void
    {
        $arr = ['a' => $this->getArrayOrNull(), 'b' => $this->getArrayOrNull()];
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'a\' => array|null, \'b\' => array|null)', $arr);
        $cond = isset($arr['a']) && isset($arr['b']);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $cond);
    }
}

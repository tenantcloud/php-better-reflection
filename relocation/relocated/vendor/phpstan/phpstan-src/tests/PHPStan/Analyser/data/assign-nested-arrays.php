<?php

namespace TenantCloud\BetterReflection\Relocated\AssignNestedArrays;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(int $i)
    {
        $array = [];
        $array[$i]['bar'] = 1;
        $array[$i]['baz'] = 2;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, array(\'bar\' => 1, \'baz\' => 2)>&nonEmpty', $array);
    }
    public function doBar(int $i, int $j)
    {
        $array = [];
        $array[$i][$j]['bar'] = 1;
        $array[$i][$j]['baz'] = 2;
        echo $array[$i][$j]['bar'];
        echo $array[$i][$j]['baz'];
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, array<int, array(\'bar\' => 1, \'baz\' => 2)>&nonEmpty>&nonEmpty', $array);
    }
}

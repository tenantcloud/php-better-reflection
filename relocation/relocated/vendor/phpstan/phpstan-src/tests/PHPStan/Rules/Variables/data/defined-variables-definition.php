<?php

namespace TenantCloud\BetterReflection\Relocated\DefinedVariables;

function &refFunction()
{
    $obj = new \stdClass();
    return $obj;
}
function funcWithSpecialParameter($one, $two, &$three)
{
    $three = 'test';
}
function functionWithByRefParameter(&$test)
{
}
class Foo
{
    public function doFoo($one, $two, &$three)
    {
        $three = 'test';
    }
    public static function doStaticFoo($one, $two, &$three)
    {
        $three = 'anotherTest';
    }
}

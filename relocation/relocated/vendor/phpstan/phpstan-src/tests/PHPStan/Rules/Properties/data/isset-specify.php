<?php

namespace TenantCloud\BetterReflection\Relocated\IssetSpecifyAccessProperty;

class Example
{
    function foo(?\TenantCloud\BetterReflection\Relocated\IssetSpecifyAccessProperty\ObjectWithArrayProp $nullableObject) : bool
    {
        return isset($nullableObject, $nullableObject->arrayProperty['key'], $nullableObject->fooProperty['foo']);
    }
}
class ObjectWithArrayProp
{
    /** @var mixed[] */
    public $arrayProperty;
}

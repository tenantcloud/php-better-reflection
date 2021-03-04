<?php

namespace TenantCloud\BetterReflection\Relocated\MethodSignature;

class Foo
{
    /**
     * @param int $value
     */
    public static function doFoo($value)
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\MethodSignature\Foo
{
    /**
     * @param string $value
     */
    public static function doFoo($value)
    {
    }
}

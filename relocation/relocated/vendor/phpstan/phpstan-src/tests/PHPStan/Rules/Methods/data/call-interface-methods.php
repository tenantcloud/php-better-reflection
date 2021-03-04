<?php

namespace TenantCloud\BetterReflection\Relocated\InterfaceMethods;

interface Foo
{
    public function fooMethod();
    public static function fooStaticMethod();
}
abstract class Bar implements \TenantCloud\BetterReflection\Relocated\InterfaceMethods\Foo
{
}
abstract class Baz extends \TenantCloud\BetterReflection\Relocated\InterfaceMethods\Bar
{
    public function bazMethod()
    {
        $this->fooMethod();
        $this->barMethod();
        self::fooStaticMethod();
        self::barStaticMethod();
    }
}

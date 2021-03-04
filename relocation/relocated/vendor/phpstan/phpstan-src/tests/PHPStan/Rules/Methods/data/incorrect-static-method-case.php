<?php

namespace TenantCloud\BetterReflection\Relocated\IncorrectStaticMethodCase;

class Foo
{
    public static function fooBar()
    {
        self::foobar();
        self::fooBar();
    }
}

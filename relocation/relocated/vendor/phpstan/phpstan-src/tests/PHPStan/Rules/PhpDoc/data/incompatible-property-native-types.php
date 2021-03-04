<?php

// lint >= 7.4
namespace TenantCloud\BetterReflection\Relocated\IncompatiblePhpDocPropertyNativeType;

class Foo
{
    /** @var self */
    private object $selfOne;
    /** @var object */
    private \TenantCloud\BetterReflection\Relocated\self $selfTwo;
    /** @var Bar */
    private \TenantCloud\BetterReflection\Relocated\IncompatiblePhpDocPropertyNativeType\Foo $foo;
    /** @var string */
    private string $string;
    /** @var string|int */
    private string $stringOrInt;
    /** @var string */
    private ?string $stringOrNull;
}
class Bar
{
}
class Baz
{
    private string $stringProp;
}

<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\NS;

\define('DEFINED', 123);
\define('NS_DEFINED', 'xxx');
const NS_DEFINED = 456;
interface Bar
{
    const DEFINED = 'xyz';
}
class ParentFoo
{
    public const PUBLIC_DEFINED = 'xyz';
}
class Foo extends \TenantCloud\BetterReflection\Relocated\NS\ParentFoo
{
    public const PUBLIC_DEFINED = 'abc';
    protected const PROTECTED_DEFINED = 'abc';
    private const PRIVATE_DEFINED = 'abc';
    public function method($a, $b = self::PUBLIC_DEFINED, $c = \TenantCloud\BetterReflection\Relocated\NS\Foo::PUBLIC_DEFINED, $d = \TenantCloud\BetterReflection\Relocated\NS\SELF::PUBLIC_DEFINED, $e = \TenantCloud\BetterReflection\Relocated\NS\Foo::PROTECTED_DEFINED, $f = self::PROTECTED_DEFINED, $g = \TenantCloud\BetterReflection\Relocated\NS\Foo::PRIVATE_DEFINED, $h = self::PRIVATE_DEFINED, $i = self::UNDEFINED, $j = \TenantCloud\BetterReflection\Relocated\NS\Foo::UNDEFINED, $k = \TenantCloud\BetterReflection\Relocated\NS\bar::DEFINED, $l = \TenantCloud\BetterReflection\Relocated\NS\Undefined::ANY, $m = DEFINED, $n = UNDEFINED, $o = NS_DEFINED, $p = parent::PUBLIC_DEFINED)
    {
    }
}

<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3024;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
interface A
{
    function getUser() : \TenantCloud\BetterReflection\Relocated\Bug3024\U;
}
interface U
{
}
class HelloWorld
{
    /** @param U[]|A[] $arr */
    public function foo($arr) : void
    {
        foreach ($arr as $elt) {
            $admin = $elt instanceof \TenantCloud\BetterReflection\Relocated\Bug3024\A;
            if ($elt instanceof \TenantCloud\BetterReflection\Relocated\Bug3024\A) {
                $u = $elt->getUser();
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug3024\\A', $elt);
            } else {
                $u = $elt;
            }
        }
    }
    /** @param U[]|A[] $arr */
    public function bar($arr) : void
    {
        foreach ($arr as $elt) {
            if ($admin = $elt instanceof \TenantCloud\BetterReflection\Relocated\Bug3024\A) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug3024\\A', $elt);
            } else {
                $u = $elt;
            }
        }
    }
    /** @param U[]|A[] $arr */
    public function baz($arr) : void
    {
        foreach ($arr as $elt) {
            $admin = $elt instanceof \TenantCloud\BetterReflection\Relocated\Bug3024\A;
            if ($admin) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug3024\\A', $elt);
            } else {
                $u = $elt;
            }
        }
    }
}

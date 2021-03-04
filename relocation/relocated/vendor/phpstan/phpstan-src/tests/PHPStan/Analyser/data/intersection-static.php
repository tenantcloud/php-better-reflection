<?php

namespace TenantCloud\BetterReflection\Relocated\IntersectionStatic;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
interface Foo
{
    /**
     * @return static
     */
    public function returnStatic() : self;
}
interface Bar
{
}
interface Baz
{
    /**
     * @return static
     */
    public function returnStatic() : self;
}
class Lorem
{
    /**
     * @param Foo&Bar $intersection
     */
    public function doFoo($intersection)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\IntersectionStatic\\Bar&IntersectionStatic\\Foo', $intersection);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\IntersectionStatic\\Bar&IntersectionStatic\\Foo', $intersection->returnStatic());
    }
    /**
     * @param Foo&Baz $intersection
     */
    public function doBar($intersection)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\IntersectionStatic\\Baz&IntersectionStatic\\Foo', $intersection);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\IntersectionStatic\\Baz&IntersectionStatic\\Foo', $intersection->returnStatic());
    }
}

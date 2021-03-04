<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2600;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param mixed ...$x
     */
    public function doFoo($x = null)
    {
        $args = \func_get_args();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $x);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', $args);
    }
    /**
     * @param mixed ...$x
     */
    public function doBar($x = null)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $x);
    }
    /**
     * @param mixed $x
     */
    public function doBaz(...$x)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, mixed>', $x);
    }
    /**
     * @param mixed ...$x
     */
    public function doLorem(...$x)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, mixed>', $x);
    }
    public function doIpsum($x = null)
    {
        $args = \func_get_args();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $x);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', $args);
    }
}
class Bar
{
    /**
     * @param string ...$x
     */
    public function doFoo($x = null)
    {
        $args = \func_get_args();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string|null', $x);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', $args);
    }
    /**
     * @param string ...$x
     */
    public function doBar($x = null)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string|null', $x);
    }
    /**
     * @param string $x
     */
    public function doBaz(...$x)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $x);
    }
    /**
     * @param string ...$x
     */
    public function doLorem(...$x)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $x);
    }
}
function foo($x, string ...$y) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $x);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $y);
}
function ($x, string ...$y) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $x);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $y);
};

<?php

namespace TenantCloud\BetterReflection\Relocated\InstanceOfClassString;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(\TenantCloud\BetterReflection\Relocated\InstanceOfClassString\Foo $foo) : void
    {
        $class = \get_class($foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<InstanceOfClassString\\Foo>', $class);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(self::class, $foo);
        if ($foo instanceof $class) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(self::class, $foo);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(self::class, $foo);
        }
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\InstanceOfClassString\Foo
{
    public function doBar(\TenantCloud\BetterReflection\Relocated\InstanceOfClassString\Foo $foo, \TenantCloud\BetterReflection\Relocated\InstanceOfClassString\Bar $bar) : void
    {
        $class = \get_class($bar);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<InstanceOfClassString\\Bar>', $class);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\InstanceOfClassString\Foo::class, $foo);
        if ($foo instanceof $class) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(self::class, $foo);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfClassString\\Foo~InstanceOfClassString\\Bar', $foo);
        }
    }
}

<?php

namespace TenantCloud\BetterReflection\Relocated\StaticMethods;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /** @return array<static> */
    public function method()
    {
    }
    /** @return array<static> */
    public function staticMethod()
    {
    }
    public function doFoo()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticMethods\\Foo)>', $this->method());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticMethods\\Foo)>', $this->method()[0]->method());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticMethods\\Foo)>', self::staticMethod());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticMethods\\Foo)>', static::staticMethod());
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\StaticMethods\Foo
{
    public function doFoo()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticMethods\\Bar)>', $this->method());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticMethods\\Bar)>', $this->method()[0]->method());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticMethods\\Bar)>', self::staticMethod());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticMethods\\Bar)>', static::staticMethod());
    }
}
function (\TenantCloud\BetterReflection\Relocated\StaticMethods\Foo $foo, \TenantCloud\BetterReflection\Relocated\StaticMethods\Bar $bar) {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<StaticMethods\\Foo>', $foo->method());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<StaticMethods\\Bar>', $bar->method());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<StaticMethods\\Bar>', $bar->method()[0]->method());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<StaticMethods\\Foo>', \TenantCloud\BetterReflection\Relocated\StaticMethods\Foo::staticMethod());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<StaticMethods\\Bar>', \TenantCloud\BetterReflection\Relocated\StaticMethods\Bar::staticMethod());
};

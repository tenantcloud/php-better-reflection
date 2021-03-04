<?php

namespace TenantCloud\BetterReflection\Relocated\StaticProperties;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /** @var array<static> */
    public $prop;
    /** @var array<static> */
    public static $staticProp;
    public function doFoo()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticProperties\\Foo)>', $this->prop);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticProperties\\Foo)>', $this->prop[0]->prop);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticProperties\\Foo)>', self::$staticProp);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticProperties\\Foo)>', static::$staticProp);
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\StaticProperties\Foo
{
    public function doFoo()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticProperties\\Bar)>', $this->prop);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticProperties\\Bar)>', $this->prop[0]->prop);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticProperties\\Bar)>', self::$staticProp);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<static(StaticProperties\\Bar)>', static::$staticProp);
    }
}
function (\TenantCloud\BetterReflection\Relocated\StaticProperties\Foo $foo, \TenantCloud\BetterReflection\Relocated\StaticProperties\Bar $bar) {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<StaticProperties\\Foo>', $foo->prop);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<StaticProperties\\Bar>', $bar->prop);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<StaticProperties\\Foo>', \TenantCloud\BetterReflection\Relocated\StaticProperties\Foo::$staticProp);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<StaticProperties\\Bar>', \TenantCloud\BetterReflection\Relocated\StaticProperties\Bar::$staticProp);
};

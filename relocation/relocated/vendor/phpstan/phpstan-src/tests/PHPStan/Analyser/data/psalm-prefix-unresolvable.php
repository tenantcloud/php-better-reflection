<?php

namespace TenantCloud\BetterReflection\Relocated\PsalmPrefixedTagsWithUnresolvableTypes;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @return array<int, string>
     * @psalm-return list<string>
     */
    public function doFoo()
    {
        return [];
    }
    public function doBar() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $this->doFoo());
    }
    /**
     * @param Foo $param
     * @param Foo $param2
     * @psalm-param foo-bar $param
     * @psalm-param foo-bar<Test> $param2
     */
    public function doBaz($param, $param2)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PsalmPrefixedTagsWithUnresolvableTypes\\Foo', $param);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PsalmPrefixedTagsWithUnresolvableTypes\\Foo', $param2);
    }
}

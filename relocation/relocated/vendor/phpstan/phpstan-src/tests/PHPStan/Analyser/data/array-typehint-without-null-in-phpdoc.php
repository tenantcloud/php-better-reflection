<?php

namespace TenantCloud\BetterReflection\Relocated\ArrayTypehintWithoutNullInPhpDoc;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @return string[]
     */
    public function doFoo() : ?array
    {
        return ['foo'];
    }
    public function doBar() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>|null', $this->doFoo());
    }
    /**
     * @param string[] $a
     */
    public function doBaz(?array $a) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>|null', $a);
    }
}

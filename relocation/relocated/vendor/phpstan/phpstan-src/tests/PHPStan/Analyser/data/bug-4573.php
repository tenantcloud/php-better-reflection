<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4573;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Bar
{
    public function doFoo() : void
    {
    }
}
class Foo
{
    /**
     * @param string|Bar $stringOrObject
     */
    public function doFoo($stringOrObject) : void
    {
        if (\is_callable([$stringOrObject, 'doFoo'])) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug4573\\Bar|class-string', $stringOrObject);
        }
    }
    /**
     * @param string|Bar $stringOrObject
     */
    public function doBar($stringOrObject) : void
    {
        if (\method_exists($stringOrObject, 'doFoo')) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug4573\\Bar|class-string', $stringOrObject);
        }
    }
}

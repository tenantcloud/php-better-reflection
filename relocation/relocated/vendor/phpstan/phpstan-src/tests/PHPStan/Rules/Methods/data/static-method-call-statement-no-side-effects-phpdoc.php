<?php

namespace TenantCloud\BetterReflection\Relocated\StaticMethodCallStatementNoSideEffects;

class BzzStatic
{
    static function regular(string $a) : string
    {
        return $a;
    }
    /**
     * @phpstan-pure
     */
    static function pure1(string $a) : string
    {
        return $a;
    }
    /**
     * @psalm-pure
     */
    static function pure2(string $a) : string
    {
        return $a;
    }
    /**
     * @pure
     */
    static function pure3(string $a) : string
    {
        return $a;
    }
}
function () : void {
    \TenantCloud\BetterReflection\Relocated\StaticMethodCallStatementNoSideEffects\BzzStatic::regular('test');
    \TenantCloud\BetterReflection\Relocated\StaticMethodCallStatementNoSideEffects\BzzStatic::pure1('test');
    \TenantCloud\BetterReflection\Relocated\StaticMethodCallStatementNoSideEffects\BzzStatic::pure2('test');
    \TenantCloud\BetterReflection\Relocated\StaticMethodCallStatementNoSideEffects\BzzStatic::pure3('test');
};
class PureThrows
{
    /**
     * @phpstan-pure
     * @throws void
     */
    public static function pureAndThrowsVoid()
    {
    }
    /**
     * @phpstan-pure
     * @throws \Exception
     */
    public static function pureAndThrowsException()
    {
    }
    public function doFoo() : void
    {
        self::pureAndThrowsVoid();
        self::pureAndThrowsException();
    }
}

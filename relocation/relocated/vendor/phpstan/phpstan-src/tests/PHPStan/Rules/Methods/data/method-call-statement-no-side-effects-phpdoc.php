<?php

namespace TenantCloud\BetterReflection\Relocated\MethodCallStatementNoSideEffects;

class Bzz
{
    function regular(string $a) : string
    {
        return $a;
    }
    /**
     * @phpstan-pure
     */
    function pure1(string $a) : string
    {
        return $a;
    }
    /**
     * @psalm-pure
     */
    function pure2(string $a) : string
    {
        return $a;
    }
    /**
     * @psalm-pure
     */
    function pure3(string $a) : string
    {
        return $a;
    }
}
function () : void {
    (new \TenantCloud\BetterReflection\Relocated\MethodCallStatementNoSideEffects\Bzz())->regular('test');
    (new \TenantCloud\BetterReflection\Relocated\MethodCallStatementNoSideEffects\Bzz())->pure1('test');
    (new \TenantCloud\BetterReflection\Relocated\MethodCallStatementNoSideEffects\Bzz())->pure2('test');
    (new \TenantCloud\BetterReflection\Relocated\MethodCallStatementNoSideEffects\Bzz())->pure3('test');
};

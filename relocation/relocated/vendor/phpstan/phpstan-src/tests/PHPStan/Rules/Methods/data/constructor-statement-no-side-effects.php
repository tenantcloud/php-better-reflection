<?php

namespace TenantCloud\BetterReflection\Relocated\ConstructorStatementNoSideEffects;

function () {
    new \Exception();
    throw new \Exception();
};
function () {
    new \PDOStatement();
    new \stdClass();
};
class ConstructorWithPure
{
    /**
     * @phpstan-pure
     */
    public function __construct()
    {
    }
}
class ConstructorWithPureAndThrowsVoid
{
    /**
     * @phpstan-pure
     * @throws void
     */
    public function __construct()
    {
    }
}
class ConstructorWithPureAndThrowsException
{
    /**
     * @phpstan-pure
     * @throws \Exception
     */
    public function __construct()
    {
    }
}
function () : void {
    new \TenantCloud\BetterReflection\Relocated\ConstructorStatementNoSideEffects\ConstructorWithPure();
    new \TenantCloud\BetterReflection\Relocated\ConstructorStatementNoSideEffects\ConstructorWithPureAndThrowsVoid();
    new \TenantCloud\BetterReflection\Relocated\ConstructorStatementNoSideEffects\ConstructorWithPureAndThrowsException();
};

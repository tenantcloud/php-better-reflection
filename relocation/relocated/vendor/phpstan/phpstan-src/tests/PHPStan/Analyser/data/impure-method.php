<?php

namespace TenantCloud\BetterReflection\Relocated\ImpureMethod;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /** @var int */
    private $fooProp;
    public function voidMethod() : void
    {
        $this->fooProp = \rand(0, 1);
    }
    public function ordinaryMethod() : int
    {
        return 1;
    }
    /**
     * @phpstan-impure
     * @return int
     */
    public function impureMethod() : int
    {
        $this->fooProp = \rand(0, 1);
        return $this->fooProp;
    }
    /**
     * @impure
     * @return int
     */
    public function impureMethod2() : int
    {
        $this->fooProp = \rand(0, 1);
        return $this->fooProp;
    }
    public function doFoo() : void
    {
        $this->fooProp = 1;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $this->fooProp);
        $this->voidMethod();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $this->fooProp);
    }
    public function doBar() : void
    {
        $this->fooProp = 1;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $this->fooProp);
        $this->ordinaryMethod();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $this->fooProp);
    }
    public function doBaz() : void
    {
        $this->fooProp = 1;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $this->fooProp);
        $this->impureMethod();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $this->fooProp);
    }
    public function doLorem() : void
    {
        $this->fooProp = 1;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $this->fooProp);
        $this->impureMethod2();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $this->fooProp);
    }
}

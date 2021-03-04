<?php

namespace TenantCloud\BetterReflection\Relocated\Bug1661;

interface I1
{
    public function someMethod();
}
interface I2
{
    public function someOtherMethod();
}
class Foo
{
    /**
     * @return I1&static
     */
    public function bar()
    {
        if ($this instanceof \TenantCloud\BetterReflection\Relocated\Bug1661\I1) {
            return $this;
        }
        throw new \Exception('bad');
    }
    /**
     * @return I2&static
     */
    public function bat()
    {
        if ($this instanceof \TenantCloud\BetterReflection\Relocated\Bug1661\I2) {
            return $this;
        }
        throw new \Exception('bad');
    }
}
function () : void {
    $a = (new \TenantCloud\BetterReflection\Relocated\Bug1661\Foo())->bar();
    $b = $a->bat();
    $b->someMethod();
    $b->someOtherMethod();
};

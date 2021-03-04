<?php

namespace TenantCloud\BetterReflection\Relocated\TestStringables;

use Stringable;
class Foo
{
    public function __toString() : string
    {
        return 'foo';
    }
}
class Bar implements \Stringable
{
    public function __toString() : string
    {
        return 'foo';
    }
}
interface Lorem extends \Stringable
{
}
class Baz
{
    public function doFoo(\Stringable $s) : void
    {
    }
    public function doBar(\TenantCloud\BetterReflection\Relocated\TestStringables\Lorem $l) : void
    {
        $this->doFoo(new \TenantCloud\BetterReflection\Relocated\TestStringables\Foo());
        $this->doFoo(new \TenantCloud\BetterReflection\Relocated\TestStringables\Bar());
        $this->doFoo($l);
        $this->doBaz($l);
    }
    public function doBaz(string $s) : void
    {
    }
}

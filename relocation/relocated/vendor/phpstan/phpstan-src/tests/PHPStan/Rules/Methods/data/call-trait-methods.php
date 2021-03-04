<?php

namespace TenantCloud\BetterReflection\Relocated\CallTraitMethods;

trait Foo
{
    public function fooMethod()
    {
    }
}
class Bar
{
    use Foo;
}
class Baz extends \TenantCloud\BetterReflection\Relocated\CallTraitMethods\Bar
{
    public function bazMethod()
    {
        $this->fooMethod();
        $this->unexistentMethod();
    }
}

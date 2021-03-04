<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4017_3;

class Foo
{
}
class Bar
{
    /**
     * @template T of Foo
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
class Baz extends \TenantCloud\BetterReflection\Relocated\Bug4017_3\Bar
{
    /**
     * @template T of Foo
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
class Lorem extends \TenantCloud\BetterReflection\Relocated\Bug4017_3\Bar
{
    /**
     * @template T of \stdClass
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}

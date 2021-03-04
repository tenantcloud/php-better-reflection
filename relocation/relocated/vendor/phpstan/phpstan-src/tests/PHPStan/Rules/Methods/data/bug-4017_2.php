<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4017_2;

class Foo
{
}
/**
 * @template T
 */
class Bar
{
    /**
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
/**
 * @extends Bar<Foo>
 */
class Baz extends \TenantCloud\BetterReflection\Relocated\Bug4017_2\Bar
{
    /**
     * @param Foo $a
     */
    public function doFoo($a)
    {
    }
}
/**
 * @extends Bar<\stdClass>
 */
class Lorem extends \TenantCloud\BetterReflection\Relocated\Bug4017_2\Bar
{
    /**
     * @param Foo $a
     */
    public function doFoo($a)
    {
    }
}

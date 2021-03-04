<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocFromTrait;

class Foo implements \TenantCloud\BetterReflection\Relocated\InheritDocFromTrait\FooInterface
{
    use FooTrait;
}
trait FooTrait
{
    /**
     * {@inheritdoc}
     */
    public function doFoo($string)
    {
        die;
    }
}
interface FooInterface
{
    /**
     * @param string $string
     */
    public function doFoo($string);
}

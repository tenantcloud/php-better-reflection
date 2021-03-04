<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocWithoutCurlyBracesFromTrait;

class Foo implements \TenantCloud\BetterReflection\Relocated\InheritDocWithoutCurlyBracesFromTrait\FooInterface
{
    use FooTrait;
}
trait FooTrait
{
    /**
     * @inheritdoc
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

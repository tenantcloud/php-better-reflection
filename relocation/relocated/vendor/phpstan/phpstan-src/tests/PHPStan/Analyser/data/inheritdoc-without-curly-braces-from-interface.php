<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocWithoutCurlyBracesFromInterface;

class Foo extends \TenantCloud\BetterReflection\Relocated\InheritDocWithoutCurlyBracesFromInterface\FooParent implements \TenantCloud\BetterReflection\Relocated\InheritDocWithoutCurlyBracesFromInterface\FooInterface
{
    /**
     * @inheritdoc
     */
    public function doFoo($string)
    {
        die;
    }
}
abstract class FooParent
{
}
interface FooInterface
{
    /**
     * @param string $string
     */
    public function doFoo($string);
}

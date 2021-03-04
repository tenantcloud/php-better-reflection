<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocFromInterface;

class Foo extends \TenantCloud\BetterReflection\Relocated\InheritDocFromInterface\FooParent implements \TenantCloud\BetterReflection\Relocated\InheritDocFromInterface\FooInterface
{
    /**
     * {@inheritdoc}
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

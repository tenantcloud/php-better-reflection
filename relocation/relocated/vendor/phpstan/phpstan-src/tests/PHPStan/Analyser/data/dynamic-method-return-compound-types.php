<?php

namespace TenantCloud\BetterReflection\Relocated\DynamicMethodReturnCompoundTypes;

class Collection
{
    public function getSelf()
    {
    }
}
class Foo
{
    public function getSelf()
    {
    }
    /**
     * @param Collection|Foo[] $collection
     * @param Collection|Foo $collectionOrFoo
     */
    public function doFoo($collection, $collectionOrFoo)
    {
        die;
    }
}

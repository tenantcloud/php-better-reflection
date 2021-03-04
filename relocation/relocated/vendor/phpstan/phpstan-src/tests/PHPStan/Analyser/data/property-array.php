<?php

namespace TenantCloud\BetterReflection\Relocated\PropertyArray;

class Foo
{
    private $property;
    public function doFoo()
    {
        'start';
        $this->property = [];
        'emptyArray';
        $this->property['foo'] = 1;
        'afterAssignment';
    }
}

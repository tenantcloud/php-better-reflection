<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\DuplicatedPromotedProperty;

class Foo
{
    private $foo;
    public function __construct(private $foo, private $bar, private $bar)
    {
    }
}

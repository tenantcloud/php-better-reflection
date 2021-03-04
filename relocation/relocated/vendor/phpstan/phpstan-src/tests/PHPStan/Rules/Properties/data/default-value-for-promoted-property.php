<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\DefaultValueForPromotedProperty;

class Foo
{
    public function __construct(
        private int $foo = 'foo',
        /** @var int */
        private $foo = '',
        private int $baz = 1
    )
    {
    }
}

<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\InstantiationPromotedProperties;

class Foo
{
    public function __construct(
        private array $foo,
        /** @var array<string> */
        private array $bar
    )
    {
    }
}
class Bar
{
    /**
     * @param array<string> $bar
     */
    public function __construct(private array $foo, private array $bar)
    {
    }
}
function () {
    new \TenantCloud\BetterReflection\Relocated\InstantiationPromotedProperties\Foo([], ['foo']);
    new \TenantCloud\BetterReflection\Relocated\InstantiationPromotedProperties\Foo([], [1]);
    new \TenantCloud\BetterReflection\Relocated\InstantiationPromotedProperties\Bar([], ['foo']);
    new \TenantCloud\BetterReflection\Relocated\InstantiationPromotedProperties\Bar([], [1]);
};

<?php

namespace TenantCloud\BetterReflection\Relocated\TypesNamespaceTypehints;

class FooWithAnonymousFunction
{
    public function doFoo()
    {
        function (int $integer, bool $boolean, string $string, float $float, \TenantCloud\BetterReflection\Relocated\TypesNamespaceTypehints\Lorem $loremObject, $mixed, array $array, bool $isNullable = Null, callable $callable, self $self) {
            die;
        };
    }
}

<?php

namespace TenantCloud\BetterReflection\Relocated\TypesNamespaceTypehints;

class Foo
{
    public function doFoo(int $integer, bool $boolean, string $string, float $float, \TenantCloud\BetterReflection\Relocated\TypesNamespaceTypehints\Lorem $loremObject, $mixed, array $array, bool $isNullable = null, callable $callable, string ...$variadicStrings) : \TenantCloud\BetterReflection\Relocated\TypesNamespaceTypehints\Bar
    {
        $loremObjectRef = $loremObject;
        $barObject = $this->doFoo();
        $fooObject = new self();
        $anotherBarObject = $fooObject->doFoo();
        die;
    }
}

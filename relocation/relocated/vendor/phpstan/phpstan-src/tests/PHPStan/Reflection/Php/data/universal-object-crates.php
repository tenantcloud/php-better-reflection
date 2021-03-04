<?php

namespace TenantCloud\BetterReflection\Relocated\UniversalObjectCreates;

class DifferentGetSetTypes
{
    private $values = [];
    public function __get($name) : \TenantCloud\BetterReflection\Relocated\UniversalObjectCreates\DifferentGetSetTypesValue
    {
        $this->values[$name] ?: new \TenantCloud\BetterReflection\Relocated\UniversalObjectCreates\DifferentGetSetTypesValue();
    }
    public function __set($name, string $value) : void
    {
        $newValue = new \TenantCloud\BetterReflection\Relocated\UniversalObjectCreates\DifferentGetSetTypesValue();
        $newValue->value = $value;
        $this->values[$name] = $newValue;
    }
}
class DifferentGetSetTypesValue
{
    public $value = null;
}

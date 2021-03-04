<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocTemplateTypeResolution;

class Foo extends \SimpleXMLElement
{
    public function removeThis() : void
    {
        unset($this[0]);
    }
}

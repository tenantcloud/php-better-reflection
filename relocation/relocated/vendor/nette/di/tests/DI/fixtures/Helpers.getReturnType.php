<?php

namespace TenantCloud\BetterReflection\Relocated\NS;

use TenantCloud\BetterReflection\Relocated\Test\B;
class A
{
    public function noType()
    {
    }
    public function classType() : \TenantCloud\BetterReflection\Relocated\Test\B
    {
    }
    public function nativeType() : string
    {
    }
    public function selfType() : self
    {
    }
    public function nullableClassType() : ?\TenantCloud\BetterReflection\Relocated\Test\B
    {
    }
    public function nullableNativeType() : ?string
    {
    }
    public function nullableSelfType() : ?self
    {
    }
    /** @return B */
    public function annotationClassType()
    {
    }
    /** @return B|string */
    public function annotationUnionType()
    {
    }
    /** @return string */
    public function annotationNativeType()
    {
    }
    /** @return self */
    public function annotationSelfType()
    {
    }
    /** @return static */
    public function annotationStaticType()
    {
    }
}
/** @return B */
function annotationClassType()
{
}
